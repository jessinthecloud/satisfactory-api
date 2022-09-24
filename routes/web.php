<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
//    dump(json_decode(Storage::disk('public')->get('data.json')));
//    Cache::flush();
    /*$data = Cache::remember('raw-game-data', 300, function () {
        return collect(json_decode(Storage::disk('public')->get('Docs.json')));
    });

    dump($data->all());*/
//    dump(json_decode(Storage::disk('public')->get('Docs.pretty.json')));

/*    $raw_data = '[
  {
    "NativeClass": "Class\'/Script/FactoryGame.FGItemDescriptor\'",
    "Classes": [
      {
        "mFluidColor": "(B\u003d0,G\u003d0,R\u003d0,A\u003d0)",
        "mGasColor": "(B\u003d0,G\u003d0,R\u003d0,A\u003d0)"
      }
      ]
    }
]';

    echo "Detected encoding: "; var_dump(mb_detect_encoding($raw_data, null, strict: true));
    echo "<BR><HR><BR>"; 
    
    print_r(json_decode(
        $raw_data,
        null,
        512,
        JSON_INVALID_UTF8_IGNORE | JSON_PARTIAL_OUTPUT_ON_ERROR 
    ));*/
    
    // don't replace invalid chars with < ? > 
    ini_set('mbstring.substitute_character', 'none');
    
    $regex = <<<'END'
/
  (
    (?: [\x00-\x7F]                 # single-byte sequences   0xxxxxxx
    |   [\xC0-\xDF][\x80-\xBF]      # double-byte sequences   110xxxxx 10xxxxxx
    |   [\xE0-\xEF][\x80-\xBF]{2}   # triple-byte sequences   1110xxxx 10xxxxxx * 2
    |   [\xF0-\xF7][\x80-\xBF]{3}   # quadruple-byte sequence 11110xxx 10xxxxxx * 3 
    ){1,100}                        # ...one or more times
  )
| .                                 # anything else
/x
END;
    
     $raw_data = Storage::disk('public')->get('Docs.pretty.json');
     
     $replaced_data = preg_replace($regex, '$1', $raw_data);
    
     echo "Detected encoding: "; var_dump(mb_detect_encoding($replaced_data, null, strict: true));
    echo "<BR><HR><BR>";

    $json_data = json_decode(
        $replaced_data,
        null,
        512,
        JSON_INVALID_UTF8_IGNORE
//        JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE | JSON_UNESCAPED_LINE_TERMINATORS | JSON_PARTIAL_OUTPUT_ON_ERROR 
    );
    echo match (json_last_error()) {
        JSON_ERROR_NONE => ' - No errors',
        JSON_ERROR_DEPTH => ' - Maximum stack depth exceeded',
        JSON_ERROR_STATE_MISMATCH => ' - Underflow or the modes mismatch',
        JSON_ERROR_CTRL_CHAR => ' - Unexpected control character found',
        JSON_ERROR_SYNTAX => ' - Syntax error, malformed JSON',
        JSON_ERROR_UTF8 => ' - Malformed UTF-8 characters, possibly incorrectly encoded',
        default => ' - Unknown error',
    };
    echo "<BR><HR><BR>";
    print_r($json_data);
//    print_r(htmlspecialchars(file_get_contents('/var/www/html/storage/app/public/Docs.pretty.json'), ENT_IGNORE));
//    print_r(json_decode(utf8_encode(trim(Storage::disk('public')->get('Docs.json')))));
    /*$data->each(function ($item, $key) {
        
    });*/
});
