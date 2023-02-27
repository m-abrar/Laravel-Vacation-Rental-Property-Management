<?php
namespace App\Http\Controllers\Owner\Transactions;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionsFormRequest;
use App\Http\Controllers\Owner\OwnerController as Panel;
use Illuminate\Http\Request;
class TransactionsController extends Controller
{
    //List of transactions
    public function index(Panel $panel)
    {
        $properties    = Properties::select('id')->where('user_id', \Auth::user()->id)->get()->toArray();
        $reservations          = Reservations::select('id')->whereIn('property_id', $properties)->get()->toArray();

        $transactions_received = Transactions::whereIn('reservation_id', $reservations)->where('status', 'paid')->orderBy('date_paid', 'desc')->get();
        $transactions_due      = Transactions::whereIn('reservation_id', $reservations)->where('status', 'pending')->orderBy('date_due', 'asc')->get();
        $settings              = Settings::find(1);
        $user                  = \Auth::user();
        $notifications         = $panel->notifications();
        $js                    = "$('#treeview-business').addClass('active');\n";
        return view('owner.transactions.index')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('transactions_received', $transactions_received)->with('transactions_due', $transactions_due)->with('js', $js);
    }
    //Add form
    public function create()
    {
        return view('owner.transactions.create');
    }
    //Inserts to database
    public function store(TransactionsFormRequest $request)
    {
        $transactions        = new Transactions();
        $transactions->title = $request->get('title');
        $transactions->slug  = str_slug($transactions->title);
        $transactions->save();
        $message = 'Successfully saved';
        return redirect('owner/transactions/edit/' . $transactions->id)->withMessage($message);
    }
    //Form for making changes into record
    public function edit($id)
    {
        $transactions = Transactions::where('id', $id)->first();
        return view('owner.transactions.edit')->with('transactions', $transactions);
    }
    //Update the table row
    public function update(TransactionsFormRequest $request)
    {
        //
        $id           = $request->input('id');
        $transactions = Transactions::find($id);
        $title        = $request->input('title');
        $slug         = str_slug($title);
        $duplicate    = Transactions::where('slug', $slug)->first();
        if ($duplicate) {
            if ($duplicate->id != $id) {
                return redirect('/owner/transactions/edit/' . $id)->withErrors('Title or slug already exists.')->withInput();
            } //$duplicate->id != $id
        } //$duplicate
        $transactions->slug  = $slug;
        $transactions->title = $title;
        $message             = 'Successfully saved';
        $transactions->save();
        return redirect('/owner/transactions/edit/' . $id)->withMessage($message);
    }
    //Deletes
    public function destroy(Request $request, $id)
    {
        $transactions = Transactions::find($id);
        $transactions->delete();
        $data['message'] = 'Successfully deleted';
        return redirect('/owner/transactions')->with($data);
    }
}
