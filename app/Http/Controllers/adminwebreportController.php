<?php

namespace App\Http\Controllers;

use App\Models\comopany;
use App\Models\siteriports;
use Illuminate\Http\Request;

class adminwebreportController extends Controller
{
    public function index()
    {
        $reportinfo = siteriports::latest()->paginate(30);
        $reportinfo_treshed = siteriports::onlyTrashed()->get();

        return view('dashbord.admin.adminwebreportshow', compact('reportinfo', 'reportinfo_treshed'));
    }

    public function create()
    {
        $componies = comopany::all();

        return view('dashbord.admin.adminreportesweb', compact('componies'));
    }

    public function store(Request $request)
    {

        $request->validate([
            $request->url => 'url',
        ]);
        //siterepord data store
        siteriports::create([
            'company' => $request->company,
            'email' => $request->email,
            'site_name' => $request->site_name,
            'url' => $request->url,
            'user_name' => $request->user_name,
            'user_id' => $request->user_id,
            'password' => $request->password,
            'verifi_code' => $request->verifi_code,
            'payment_date' => $request->payment_date,
            'why_create' => $request->why_create,
            'number' => $request->number,
            'card_holder_name' => $request->card_holder_name,
            'card_number' => $request->card_number,
            'currency' => $request->currency,
            'expairy_date' => $request->expairy_date,
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->bank_account_number,
            'exchange_name' => $request->exchange_name,
            'exchange_account_number' => $request->exchange_account_number,
            'bank_card_number' => $request->bank_card_number,
            'Pin' => $request->Pin,
            'online_transfer_Password' => $request->online_transfer_Password,
            'note' => $request->note,
            'created_at' => now(),
        ]);
        $notification = array(
            'message' => 'Information submit Successfully',
            'alert-type' => 'success'
            );
       return redirect()->back()->with($notification);
    }

   public function edit($id)
   {
       $componies = comopany::all();
       $sitereports = siteriports::find($id);

       return view('dashbord.admin.adminwebreportedit', compact('sitereports', 'componies'));
   }

    public function update(Request $request, $id)
    {
            siteriports::find($id)->update([
                'company' => $request->company,
                'email' => $request->email,
                'site_name' => $request->site_name,
                'url' => $request->url,
                'user_name' => $request->user_name,
                'user_id' => $request->user_id,
                'password' => $request->password,
                'verifi_code' => $request->verifi_code,
                'payment_date' => $request->payment_date,
                'why_create' => $request->why_create,
                'number' => $request->number,
                'card_holder_name' => $request->card_holder_name,
                'card_number' => $request->card_number,
                'currency' => $request->currency,
                'expairy_date' => $request->expairy_date,
                'bank_name' => $request->bank_name,
                'bank_account_number' => $request->bank_account_number,
                'exchange_name' => $request->exchange_name,
                'exchange_account_number' => $request->exchange_account_number,
                'bank_card_number' => $request->bank_card_number,
                'Pin' => $request->Pin,
                'online_transfer_Password' => $request->online_transfer_Password,
                'note' => $request->note,
            ]);

            $notification = array(
                'message' => 'Information update Successfully',
                'alert-type' => 'success'
                );
           return redirect()->back()->with($notification);

    }

    public function destroy($id)
    {
        siteriports::find($id)->delete();
        $notification = array(
            'message' => 'Information tem delete',
            'alert-type' => 'success'
            );
       return redirect()->back()->with($notification);
    }

    public function restor($id)
    {
        siteriports::onlyTrashed()->find($id)->restore();
        $notification = array(
            'message' => 'Information restore Successfully',
            'alert-type' => 'info'
            );
       return redirect()->back()->with($notification);
    }

    public function delete($id)
    {
        siteriports::onlyTrashed()->find($id)->forceDelete();
        $notification = array(
            'message' => 'Site info Deleted Forever!',
            'alert-type' => 'success'
            );
       return redirect()->back()->with($notification);

    }

    /**
     * web report search
     */
    public function search(Request $request)
    {
        $output = ' ';
        $siteriports = siteriports::where('company', 'Like', '%'.$request->search.'%')->orWhere('email', 'Like', '%'.$request->search.'%')->orWhere('site_name', 'Like', '%'.$request->search.'%')->orWhere('url', 'Like', '%'.$request->search.'%')->orWhere('user_name', 'Like', '%'.$request->search.'%')->orWhere('user_id', 'Like', '%'.$request->search.'%')->orWhere('password', 'Like', '%'.$request->search.'%')->orWhere('verifi_code', 'Like', '%'.$request->search.'%')->orWhere('payment_date', 'Like', '%'.$request->search.'%')->orWhere('why_create', 'Like', '%'.$request->search.'%')->orWhere('number', 'Like', '%'.$request->search.'%')->orWhere('note', 'Like', '%'.$request->search.'%')->get();

        foreach ($siteriports as $siteriport) {
            $output .=

            '<tr>
            <td> '.$siteriport->company.' </td>
            <td> '.$siteriport->email.' </td>
            <td> '.$siteriport->site_name.' </td>
            <td> '.$siteriport->url.' </td>
            <td> '.$siteriport->user_name.' </td>
            <td> '.$siteriport->user_id.' </td>
            <td> '.$siteriport->password.' </td>
            <td> '.$siteriport->why_create.' </td>
            <td> '.$siteriport->number.' </td>
            <td> '.$siteriport->verifi_code.' </td>
            <td> '.$siteriport->note.' </td>
            <td> '.$siteriport->payment_date.' </td>
            <td> '.$siteriport->created_at.' </td>
            <td> '.'
            <a  class="btn btn-primary" href="/adminwebreport/edit/'.$siteriport->id.'" title="edit">
                 '.'<i class="mdi mdi-border-color"></i></a>

            <a  class="btn btn-primary" href="/adminwebreport/destroy/'.$siteriport->id.'" title="edit">
                '.'<i class="mdi mdi-delete"></i></a>
            '.' </td>
            </tr>';
        }

        return response($output);
    }

    public function view($id){
      $single_view =  siteriports::find($id);
      return view('dashbord.admin.singleview',compact('single_view'));
    }
}
