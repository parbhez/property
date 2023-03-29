<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketActivity;
use Illuminate\Http\Request;
use App\Traits\SystemLogTrait;
use Carbon\Carbon;
use Auth;
use DB;

class MarketActivityController extends Controller
{
    use SystemLogTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query=MarketActivity::whereNull('deleted_at');
    
        if(request()->filled('name'))
            $query->where('reportName','like',request()->name.'%');

        if(request()->filled('status'))
            $query->where('shareStatus',request()->status);

        $dataList=$query->paginate(100)->withQueryString();

        return view('admin.marketActivity_list',compact('dataList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.marketActivity_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
       try{
        $request->validate([
            'reportName' => 'required',
            'reportSubject' => 'required',
            'reportDetails' => 'required',
            'shareStatus' => 'required',
            'attachmentOne' => 'mimes:pdf|max:2048',
            'attachmentTwo' => 'mimes:pdf|max:2048',
            'attachmentThree' => 'mimes:pdf|max:2048',
        ],
        [
            'reportName.required' => "Please Enter Report Name.",
            'reportSubject.required' => "Please Enter Report Subject.",
            'reportDetails.required' => "No report Details Given.",
        ]);

            $dataInfo=new MarketActivity();

            $dataInfo->reportName=$request->reportName;
            $dataInfo->reportSubject=$request->reportSubject;
            $dataInfo->reportSubject=$request->reportSubject;
            $dataInfo->reportDetails=$request->reportDetails;
            $dataInfo->shareStatus=$request->shareStatus;
            if($request->hasFile('attachmentOne')){
                $file=$request->file('attachmentOne');
                $currentDate=Carbon::now()->toDateString();
                $fileName=$currentDate.'-'.uniqid().'.'.$file->getClientOriginalExtension();
                $request->attachmentOne->move(public_path('market_activity_report'), $fileName);
                $dataInfo->attachmentOne=$fileName;
            }
            if($request->hasFile('attachmentTwo')){
                $file=$request->file('attachmentTwo');
                $currentDate=Carbon::now()->toDateString();
                $fileName=$currentDate.'-'.uniqid().'.'.$file->getClientOriginalExtension();
                $request->attachmentTwo->move(public_path('market_activity_report'), $fileName);
                $dataInfo->attachmentTwo=$fileName;
            }
            if($request->hasFile('attachmentThree')){
                $file=$request->file('attachmentThree');
                $currentDate=Carbon::now()->toDateString();
                $fileName=$currentDate.'-'.uniqid().'.'.$file->getClientOriginalExtension();
                $request->attachmentThree->move(public_path('market_activity_report'), $fileName);
                $dataInfo->attachmentThree=$fileName;
            }
            $dataInfo->shareStatus=$request->shareStatus;
            $dataInfo->created_at=Carbon::now();

            if($dataInfo->save()){

                $note=$dataInfo->id."=>Market activity created by ".Auth::guard('admin')->user()->name;

                $this->storeSystemLog($dataInfo->id, 'market_activities',$note);

                DB::commit();

                return response()->json(['status'=>true ,'msg'=>'A Market activity Added Successfully.!','url'=>url()->previous()]);
            }
            else{

                 DB::rollBack();

                 return response()->json(['status'=>false ,'msg'=>'Failed To Add Market activity.!']);
            }
       }
        catch(Exception $err){

            DB::rollBack();

            $this->storeSystemError('aarketActivity','store',$err);

            DB::commit();

            return response()->json(['status'=>false ,'msg'=>'Something Went Wrong.Please Try Again.!']);
       }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($dataId)
    {
        
        $dataInfo=MarketActivity::find($dataId);
        return view('admin.marketActivity_edit',compact('dataInfo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         // dd($request->all());
         DB::beginTransaction();
         try{
          $request->validate([
              'reportName' => 'required',
              'reportSubject' => 'required',
              'reportDetails' => 'required',
              'shareStatus' => 'required',
              'attachmentOne' => 'mimes:pdf|max:2048',
              'attachmentTwo' => 'mimes:pdf|max:2048',
              'attachmentThree' => 'mimes:pdf|max:2048',
          ],
          [
              'reportName.required' => "Please Enter Report Name.",
              'reportSubject.required' => "Please Enter Report Subject.",
              'reportDetails.required' => "No report Details Given.",
          ]);
              $dataId= $request->dataId;
              $dataInfo=MarketActivity::find($dataId);
  
              $dataInfo->reportName=$request->reportName;
              $dataInfo->reportSubject=$request->reportSubject;
              $dataInfo->reportSubject=$request->reportSubject;
              $dataInfo->reportDetails=$request->reportDetails;
              $dataInfo->shareStatus=$request->shareStatus;
              if($request->hasFile('attachmentOne')){
                  $file=$request->file('attachmentOne');
                  $currentDate=Carbon::now()->toDateString();
                  $fileName=$currentDate.'-'.uniqid().'.'.$file->getClientOriginalExtension();
                  $request->attachmentOne->move(public_path('market_activity_report'), $fileName);
                  $dataInfo->attachmentOne=$fileName;
              }
              if($request->hasFile('attachmentTwo')){
                  $file=$request->file('attachmentTwo');
                  $currentDate=Carbon::now()->toDateString();
                  $fileName=$currentDate.'-'.uniqid().'.'.$file->getClientOriginalExtension();
                  $request->attachmentTwo->move(public_path('market_activity_report'), $fileName);
                  $dataInfo->attachmentTwo=$fileName;
              }
              if($request->hasFile('attachmentThree')){
                  $file=$request->file('attachmentThree');
                  $currentDate=Carbon::now()->toDateString();
                  $fileName=$currentDate.'-'.uniqid().'.'.$file->getClientOriginalExtension();
                  $request->attachmentThree->move(public_path('market_activity_report'), $fileName);
                  $dataInfo->attachmentThree=$fileName;
              }
              $dataInfo->shareStatus=$request->shareStatus;
              $dataInfo->updated_at=Carbon::now();
              if($dataInfo->save()){
  
                  $note=$dataInfo->id."=>Market activity edited by ".Auth::guard('admin')->user()->name;
  
                  $this->storeSystemLog($dataInfo->id, 'market_activities',$note);
  
                  DB::commit();
  
                  return response()->json(['status'=>true ,'msg'=>'A Market activity edited Successfully.!','url'=>url()->previous()]);
              }
              else{
  
                   DB::rollBack();
  
                   return response()->json(['status'=>false ,'msg'=>'Failed To edit Market activity.!']);
              }
         }
          catch(Exception $err){
  
              DB::rollBack();
  
              $this->storeSystemError('aarketActivity','update',$err);
  
              DB::commit();
  
              return response()->json(['status'=>false ,'msg'=>'Something Went Wrong.Please Try Again.!']);
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       DB::beginTransaction();
        
        $dataInfo=MarketActivity::find($id);

        if(!empty($dataInfo)) {

          $dataInfo->shareStatus=0;
          
          $dataInfo->deleted_at=Carbon::now();

          if($dataInfo->save()){

                $note=$dataInfo->id."=> Market Activity  info deleted  by ".Auth::guard('admin')->user()->name;

                $this->storeSystemLog($dataInfo->id, 'market_activities',$note);

                DB::commit();

                return response()->json(['status'=>true ,'msg'=>' Market Activity deleted Successfully.!']);
            }
            else{

                 DB::rollBack();

                 return response()->json(['status'=>false ,'msg'=>'Failed To Delete Market Activity Info!']);
            }
        }
        else{
           return response()->json(['status'=>false ,'msg'=>'Requested Data Not Found.!']); 
        }
    }
    public function changeStatus(Request $request)
    {

        DB::beginTransaction();
        
        $dataInfo=MarketActivity::find($request->dataId);

        if(!empty($dataInfo)) {

          $dataInfo->shareStatus=$request->status;
          
          $dataInfo->updated_at=Carbon::now();

          if($dataInfo->save()){

                $note=$dataInfo->id."=> ".$dataInfo->name." Market Activity Show Status changed by ".Auth::guard('admin')->user()->name;

                $this->storeSystemLog($dataInfo->id, 'market_activities',$note);

                DB::commit();

                return response()->json(['status'=>true ,'msg'=>' City Status Changed Successfully.!','url'=>url()->previous()]);
            }
            else{

                 DB::rollBack();

                 return response()->json(['status'=>false ,'msg'=>'Failed To Change Status!']);
            }
        }
        else{
           return response()->json(['status'=>false ,'msg'=>'Requested Data Not Found.!']); 
        }
    }
}
