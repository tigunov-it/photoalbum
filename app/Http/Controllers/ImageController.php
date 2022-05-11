<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Aws\S3\Exception\S3Exception;
use Aws\S3\MultipartCopy;
use Aws\S3\S3Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use PhpParser\Node\Expr\New_;

class ImageController extends Controller
{
    public function rotate(Post $post) {

        return 'rotate';

//       $image = Storage::disk('s3')->get("{$post->image}");

//        $s3 = new S3Client([
//            'version' => 'latest',
//            'region'  => 'us-east-1'
//        ]);
//
//        $bucket = env('AWS_BUCKET');
//        $keyname = $post->image;
//
//        $result = $s3->getObject([
//            'Bucket' => $bucket,
//            'Key'    => $keyname
//        ]);
//
//        dd($result);


    }
}
