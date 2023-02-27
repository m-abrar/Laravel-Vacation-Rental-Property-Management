<style type="text/css">
   /*NEWSLETTER CONTAINER*/
   #newsletter-container {
   background: #777;
   padding: 50px 0;
   clear: both;
   display: block;
   }
   #newsletter-container h3 {
   font-size: 25px;
   line-height: 46px;
   color: #eee;
   text-transform: uppercase;
   margin: 0;
   float: left;
   }
   #newsletter-container form {
   float: right;
   }
   #newsletter-container input[type=text] {
   height: 46px;
   width: 300px;
   vertical-align: top;
   margin-right: 5px;
   border-radius: 4px;
   border: 1px solid #ddd;
   line-height: 20px;
   padding: 5px 10px 5px 20px;
   color: #727b7c;
   }
   input, select, textarea {
   outline: 0;
   }
   #newsletter-container .btn {
   padding: 12px 20px;
   font-size: 17px;
   line-height: 20px;
   }
   #promotion-banner{
   position: relative;
   -webkit-background-size: cover;
   -moz-background-size: cover;
   background-size: cover;
   -o-background-size: cover;
   background-position: center;
   background-image: url('http://localhost/eminent/public/img/promotion-banner.jpg');
   padding: 150px 0;
   box-shadow: inset 0 0 0 1000px rgba(0, 0, 0, 0.6);
   }
   #promotion-banner .Banner-heading{
   font-family: "Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;
   text-transform: uppercase;
   font-weight: 700;
   font-size: 65px;
   line-height: 70px;
   color:#fff;}
   #promotion-banner .Banner-heading span{
   text-transform:capitalize;
   font-family: "Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;
   font-weight: 400;
   }
</style>
<div id="newsletter-container">
   <div class="container">
      <div class="row">
         <div class="col-md-12 col-sm-12 col-xs-12 clearfix">
            <h3 class="wow fadeInLeft animated" data-wow-delay="1s">Sign up to receive the latest news</h3>
            <form id="register-newsletter" class="wow fadeInRight animated" data-wow-delay="1s">
               <input type="text" class="radius-none" name="newsletter" required placeholder="Enter your email address">
               <input type="submit" class="btn btn-xl radius-none" value="SIGN UP">
            </form>
         </div>
      </div>
   </div>
</div>