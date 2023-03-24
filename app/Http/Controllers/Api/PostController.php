<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class PostController extends Controller
{
	/**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
	public function index()
	{
    return response()->json([
      'status' => true,
      'posts' => 'hrllo'
    ], 200);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
	    //
	}

  //removes PKCS7 padding
  function unpad($value)
  {
      $blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
      $packing = ord($value[strlen($value) - 1]);
      if($packing && $packing < $blockSize)
      {
          for($P = strlen($value) - 1; $P >= strlen($value) - $packing; $P--)
          {
              if(ord($value[$P]) != $packing)
              {
                  $packing = 0;
              }
          }
      }

      return substr($value, 0, strlen($value) - $packing); 
  }

  function decryptRJ256($key,$iv,$encrypted)
  {
      //PHP strips "+" and replaces with " ", but we need "+" so add it back in...
      $encrypted = str_replace(' ', '+', $encrypted);

      //get all the bits
      //$key = base64_decode($key);
      //$iv = base64_decode($iv);
      $encrypted = base64_decode($encrypted);

      $rtn = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $encrypted, MCRYPT_MODE_CBC, $iv);
      $rtn = unpad($rtn);
      return($rtn);
  }

	/**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
	public function store(StorePostRequest $request)
  {
    // Same as old rijndael-128 Mode ECB 
    $cipher ="AES-256-ECB";
    $key = '89312e97a5b4cedb398abba3432ee11f';
    // $cert_key = "HNK+JGHnoiweyr8937248nyhyB9UVBueoidy9823hud=";
    // $cert_iv = "ke+lre4wur589437yn9YKjBG83cn98fy29uxdn289de=";

    // $chiperRaw = $request->certification;
    // $text = decryptRJ256($cert_key, $cert_iv, $cipherRaw);
    $email = $request->email;
    $certification = $request->certification;
    $token = $request->token;
    $chiperRaw = openssl_encrypt($email, $cipher, $key, OPENSSL_RAW_DATA);
    $ciphertext = trim(base64_encode($chiperRaw));

    $certification = base64_decode($certification);
    $str = substr($certification, strlen($ciphertext)*(-1));

    if (substr($str, 0, 20) != substr($ciphertext, 0, 20))
      return response()->json([
        'status' => false,
        'message' => 'Internal Server Error',
      ], 500);

    $certification = substr($certification, 0, strlen($certification) - strlen($str));
    $certification = base64_decode($certification);
    $certification = substr($certification, 0, strlen($certification) - strlen($email));
    $certification = base64_decode($certification);
    $str = base64_encode($email);
    $str_tmp = substr($certification, strlen($str)*(-1));

    if ($str != $str_tmp) {
      return response()->json([
        'status' => false,
        'message' => 'Internal Server Error',
      ], 500);
    }

    $certification = substr($certification, 0, strlen($certification) - strlen($str));
    $certification = base64_decode($certification);

    $text = preg_split('/--/', $certification, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
    $password = $text[1];

    $user = User::select('email', 'password', 'type as role', 'is_approved as approve', 'is_expired as expired', 'plan_app')->where('email', $email)->first();

    if (empty($user))
      return response()->json([
        'status' => false,
        'message' => 'Invalid email or password',
      ], 500);
      
    //return abort(404);

    if (!Hash::check($password, $user->password))
      return response()->json([
        'status' => false,
        'message' => 'Invalid email or password',
      ], 500);

    if ($user->role > 3)
      return response()->json([
        'status' => false,
        'message' => 'This is hacker!!!',
      ], 500);

    if ($user->approve != 2)
      return response()->json([
        'status' => false,
        'message' => 'Blocked!',
      ], 500);

    if ($user->role == 3 && $user->expired != 1)
    {
      return response()->json([
        'status' => false,
        'message' => 'Expired',
      ], 500);
    }

    $role_level = $user->role;

    if($user->role == 2 && $user->plan_app == "PLUS") {
      $role_level = 3;
    }

    $role = array("team", "admin", "Plugin", "Pro");
    $timestamp = hash('ripemd128', date("Y-m-d h:i:sa").rand()).base64_encode(rand(0, 9).base64_encode($role[$role_level]).rand(100, 999)).hash('md5', $email.date("Y-m-d h:i:sa"));
    return response()->json([
        'status' => true,
        'message' => 'success',
        'token' => base64_encode($token).rand(),
        'timestamp' => $timestamp,
    ], 200);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function show(Post $post)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function edit(Post $post)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function update(StorePostRequest $request, Post $post)
  {
      //$post->update($request->all());
    return response()->json([
        'status' => true,
        'message' => "Post Updated successfully!",
        'post' => "eerert"
    ], 200);
  }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Post  $post
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Post $post)
	{
	    $post->delete();

	    return response()->json([
	        'status' => true,
	        'message' => "Post Deleted successfully!",
	    ], 200);
	}
}
