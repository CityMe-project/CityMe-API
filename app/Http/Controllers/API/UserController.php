<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Surveys;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'code' => request('code')])){
            $user = Auth::user();
            $data['email'] =  $user->email;
            $data['code'] =  $user->code;
            $data['token'] =  $user->createToken('CityMe')->accessToken;
            return response()->json(['success' => true, 'data' => $data], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $user = User::create($request->all());
        $data['email'] =  $user->email;
        $data['code'] =  $user->code;
        $data['token'] =  $user->createToken('CityMe')-> accessToken;
        return response()->json(['success' => true, 'data' => $data], $this->successStatus);
    }
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => true, 'data' => $user], $this->successStatus);
    }

    /**
     * verify token api
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function verify()
    {
        $user = Auth::user();
        return response()->json(['success' => true], $this-> successStatus);
    }
    /**
     * loginVerify api
     *
     * @return \Illuminate\Http\Response
     */
    public function loginVerify(Request $request){
        $input['email'] = request('email');
        $rules = array('email' => 'unique:users,email');
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $user = User::where('email',$input['email'])->get()[0];
            $survey = Surveys::where('user_id_related',$user->id)->get();
            return response()->json(['success' => true, 'submited' => count($survey)>0?$survey[0]->submited:false], $this->successStatus);
        }
        else {
            return response()->json(['success' => false], $this->successStatus);
        }
    }
}
