<?php
namespace App\Http\Controllers\Admin\Transactions;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionsFormRequest;
use App\Http\Controllers\Admin\AdminController as Panel;
use Illuminate\Http\Request;
class TransactionsController extends Controller
{
    //List of transactions
    public function index(Panel $panel)
    {
        $transactions_received = \App\Transactions::where('status', 'paid')->orderBy('date_paid', 'desc')->get();
        $transactions_due      = \App\Transactions::where('status', 'pending')->orderBy('date_due', 'asc')->get();
        $settings              = \App\Settings::find(1);
        $user                  = \Auth::user();
        $notifications         = $panel->notifications();
        $js                    = "$('#treeview-business').addClass('active');\n";
        return view('admin.transactions.index')->with('settings', $settings)->with('user', $user)->with('notifications', $notifications)->with('transactions_received', $transactions_received)->with('transactions_due', $transactions_due)->with('js', $js);
    }
    //Add form
    public function create()
    {
        return view('admin.transactions.create');
    }
    //Inserts to database
    public function store(TransactionsFormRequest $request)
    {
        $transactions        = new \App\Transactions();
        $transactions->title = $request->get('title');
        $transactions->slug  = str_slug($transactions->title);
        $transactions->save();
        $message = 'Successfully saved';
        return redirect('admin/transactions/edit/' . $transactions->id)->withMessage($message);
    }
    //Form for making changes into record
    public function edit($id)
    {
        $transactions = \App\Transactions::where('id', $id)->first();
        return view('admin.transactions.edit')->with('transactions', $transactions);
    }
    //Update the table row
    public function update(TransactionsFormRequest $request)
    {
        //
        $id           = $request->input('id');
        $transactions = \App\Transactions::find($id);
        $title        = $request->input('title');
        $slug         = str_slug($title);
        $duplicate    = \App\Transactions::where('slug', $slug)->first();
        if ($duplicate) {
            if ($duplicate->id != $id) {
                return redirect('/admin/transactions/edit/' . $id)->withErrors('Title or slug already exists.')->withInput();
            } //$duplicate->id != $id
        } //$duplicate
        $transactions->slug  = $slug;
        $transactions->title = $title;
        $message             = 'Successfully saved';
        $transactions->save();
        return redirect('/admin/transactions/edit/' . $id)->withMessage($message);
    }
    //Deletes
    public function destroy(Request $request, $id)
    {
        $transactions = \App\Transactions::find($id);
        $transactions->delete();
        $data['message'] = 'Successfully deleted';
        return redirect('/admin/transactions')->with($data);
    }
}
