<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Intervention\Image\Facades\Image;
use File;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
      
        return Validator::make($data, [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'bio' => 'required|min:6',
            'image' => 'file|required',
        ]);
       
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

             $img=  Image::make($data['image']);
        
        
              //get the name of image to use it again storing in database
        
              $imgName = $data['image']->getClientOriginalName();
        
        
        
              // modifing and customizing my image (resizing , archiving)
              $img->resize(500,null,function($ratio)
              {
              $ratio->aspectRatio();
              });
              // save the image in the directory which i need
                  $img->save(public_path('user_imgs/'.$imgName));
        
        
        return User::create([ 
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'image' => $imgName,
            'bio' => $data['bio'],
            
        ]);
    }
}
