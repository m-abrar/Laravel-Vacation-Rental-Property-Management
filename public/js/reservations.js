
function PropertyCalendar(url,property_slug, reservation_id, lineitems) {
    this.$url = url;
    this.$property_slug = property_slug;
    this.$reservation_id = reservation_id;
    this.$lineitems = lineitems;
}

PropertyCalendar.prototype = {

    constructor: PropertyCalendar,

    loadCalendar: function(year, month, date_start, date_end) {

        date_start = date_start || 'NA';
        date_end = date_end || 'NA';
        var url = this.$url + '/select-dates/' + this.$property_slug + '/' + year + '/' + month + '/' + date_start + '/' + date_end + '/' + this.$reservation_id;
        console.log(url);

        $.ajax({
            url: url,
            success: function(result) {
                $("#property-calendar-select-dates").html(result);
            }
        });
    },

    selectDates: function(currentClickCycle, currentClickedDateValue, lastClickCycleID, lastClickedDateValue) {

        $(".date-selected").removeClass('date-selected');
        $(".date-selected-start").removeClass('date-selected-start');
        $(".date-selected-end").removeClass('date-selected-end');
        


        if (lastClickCycleID == "0") { // The user just made his 1st click on the calendar while selecting the dates.
            //alert('Now please select the date of departure');
            $("#date-" + currentClickCycle).addClass("date-selected");

        } else { //The following code works if it was 2nd click of the user.

            if (lastClickCycleID < currentClickCycle) { //lets assign values to loop start and loop end variables.
                var loopStart = lastClickCycleID * 1; //make the variable purely integer.
                var loopEnd = currentClickCycle * 1; //make the variable purely integer.
            } else {
                var loopEnd = lastClickCycleID * 1;
                var loopStart = currentClickCycle * 1;
            }
            var loopContinue = loopStart;
            while (loopContinue <= loopEnd) { // Run a while loop to assign class to table cell# of a date starting forward from today.
                if(loopContinue==loopStart){$("#date-" + loopContinue).addClass("date-selected-start");}
                if(loopContinue==loopEnd){$("#date-" + loopContinue).addClass("date-selected-end");}
                $("#date-" + loopContinue).addClass("date-selected");
                loopContinue++;
            }

            //this.saveDatesSearchedToSession(lastClickedDateValue, currentClickedDateValue);
            //this.preBookingMessage(lastClickedDateValue, currentClickedDateValue);
            //this.calculatePrice(lastClickedDateValue, currentClickedDateValue);


        }
    },

    saveDatesSearchedToSession: function(lastClickedDateValue, currentClickedDateValue) {
        url = this.$url + '/save-dates-searched-to-session/' + lastClickedDateValue + "/" + currentClickedDateValue;
        $.ajax({
            url: url,
            success: function(result) {
                console.log(result);
                $("#dates-searched").val(result);
            }
        });
    },
    preBookingMessage: function(lastClickedDateValue, currentClickedDateValue) {
        $.ajax({
            url: this.$url + '/booking-availability-message/' + this.$property_slug + "/" + lastClickedDateValue + "/" + currentClickedDateValue + "/" + this.$reservation_id,
            success: function(result) {
                $("#booking-availability-message").html(result);
            }
        });
    },
    calculatePrice: function(lastClickedDateValue, currentClickedDateValue) {

        $("#calculation-error-container").hide();
        var url = this.$url + '/calculate-lodging-price/' + this.$property_slug + "/" + lastClickedDateValue + "/" + currentClickedDateValue + "/" + this.$reservation_id + "/1";

        var lineitems = this.$lineitems;
        $.ajax({
            url: url,
            success: function(result) {

                if (isNaN(result)) {

                    $("#calculation-error-container").removeClass("hidden");
                    $("#calculation-error-container").show();
                    $("#calculation-error-message").html(result);
                    var editPropertyURL = url + '/admin/properties/edit/' + $property_id;
                    $("#calculation-error-message").append('<br/><br/><a href="' + editPropertyURL + '" target="_blank">Update Rental Prices</a>');

                } else {

                    $("#calculation-error-container").addClass("hidden");
                    $("#calculation-error-container").hide();
                    $("#calculated-lodging-price").html('<strong>Lodging Total: $'+result+'</strong>');
                    $("#calculated-lodging-price").val(result);

                }

            }
        
        }).done(function() {
            

            var totalamount = lodgingamount = $("#calculated-lodging-price").val()*1 + $("#calculated-addons-price").val()*1;

            var sub_total_detail = "Lodging: $" + lodgingamount + "\n";

            for (var i = 0; i < lineitems.length; i++) {

                var lineitem_id = lineitems[i].id;
                var lineitem_title = lineitems[i].title;
                var lineitem_slug = lineitems[i].slug;
                var lineitem_required = lineitems[i].is_required;
                var lineitem_value = lineitems[i].value;
                var lineitem_type = lineitems[i].value_type;
                var lineitem_apply_on = lineitems[i].apply_on;

                if (lineitem_required == '1' || $('#lineitem-' + lineitem_id).prop('checked')) {

                    if (lineitem_type == "fixed") {

                        totalamount = +totalamount + +lineitem_value;
                        sub_total_detail += lineitem_title + ': $' + lineitem_value + "\n";

                    } 
                    else if (lineitem_type == "percentage") {

                        if (lineitem_apply_on == "base") {
                            var apply_on = lodgingamount;
                        } else {
                            var apply_on = totalamount;
                        } 

                        var calculated_value = apply_on * lineitem_value / 100; //vars['lineitem-' + lineitem_id]
                        totalamount = +totalamount + +calculated_value; //calculated_value[lineitem_id]
                        sub_total_detail += lineitem_title + '(' + lineitem_value + '%): $' + calculated_value + "\n";

                    } 

                } 

            } //i < this.$lineitems.length


            $("#sub-total-detail").val(sub_total_detail);
            $("#calculated-total-amount").val(totalamount);


        });
    },

    AddRemoveLineItems: function() {

        var totalamount = lodgingamount = $("#calculated-lodging-price").val()*1 + $("#calculated-addons-price").val()*1;

        var sub_total_detail = "Lodging: $" + this.roundNumber(lodgingamount,2) + "\n";

        for (var i = 0; i < this.$lineitems.length; i++) {

            var lineitem_id = this.$lineitems[i].id;
            var lineitem_title = this.$lineitems[i].title;
            var lineitem_slug = this.$lineitems[i].slug;
            var lineitem_required = this.$lineitems[i].is_required;
            var lineitem_value = this.$lineitems[i].value;
            var lineitem_type = this.$lineitems[i].value_type;
            var lineitem_apply_on = this.$lineitems[i].apply_on;

            if (lineitem_required == '1' || $('#lineitem-' + lineitem_id).prop('checked')) {

                if (lineitem_type == "fixed") {

                    totalamount = +totalamount + +lineitem_value;
                    sub_total_detail += lineitem_title + ': $' + this.roundNumber(lineitem_value,2) + "\n";

                } 
                else if (lineitem_type == "percentage") {

                    if (lineitem_apply_on == "base") {
                        var apply_on = lodgingamount;
                    } else {
                        var apply_on = totalamount;
                    } 

                    var calculated_value = apply_on * lineitem_value / 100;
                    totalamount = +totalamount + +calculated_value;
                    sub_total_detail += lineitem_title + '(' + lineitem_value + '%): $' + this.roundNumber(calculated_value,2) + "\n";

                } 

            } 

        } //i < this.$lineitems.length


        $("#sub-total-detail").val(sub_total_detail);
        $("#calculated-total-amount").val(this.roundNumber(totalamount,2));
        $("#calculated-total-amount").html(this.roundNumber(totalamount,2));
    },
    roundNumber: function(num, dec) {
        num = 1 * num;
        var result = num.toFixed(dec);
        return result;
    },
    is_int: function(value) {
        for (i = 0; i < value.length; i++) {
            if ((value.charAt(i) < '0') || (value.charAt(i) > '9')) return false
        }
        return true;
    }

};