<?php

use Illuminate\Support\Facades\Route;
use \ForceUTF8\Encoding;

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
//    ini_set('mbstring.substitute_character', 'none');
    
    if (!function_exists('mb_str_replace'))
{
   function mb_str_replace($search, $replace, $subject, &$count = 0)
   {
      if (!is_array($subject))
      {
         $searches = is_array($search) ? array_values($search) : array($search);
         $replacements = is_array($replace) ? array_values($replace) : array($replace);
         $replacements = array_pad($replacements, count($searches), '');
         foreach ($searches as $key => $search)
         {
            $parts = mb_split(preg_quote($search), $subject);
            $count += count($parts) - 1;
            $subject = implode($replacements[$key], $parts);
         }
      }
      else
      {
         foreach ($subject as $key => $value)
         {
            $subject[$key] = mb_str_replace($search, $replace, $value, $count);
         }
      }
      return $subject;
   }
}
    
//     $raw_data = Storage::disk('public')->get('Docs.pretty.json');
     $raw_data = file_get_contents('/var/www/html/storage/app/public/Docs-fixed.json');
//     $raw_data = mb_str_replace('™', '', $raw_data);
     
//     var_dump(Str::between($raw_data, '[ {', '} ] } ]'));
     
//     $raw_data = trim(Str::between($raw_data, '[ {', '} ] } ]'));
//     print_r($raw_data);
//     echo "<BR><BR>";
//    die;

//     $raw_data = Encoding::toUTF8($raw_data);
//     $raw_data = trim(Encoding::fixUTF8($raw_data, Encoding::ICONV_IGNORE));
//     $raw_data = Encoding::fixUTF8($raw_data, Encoding::ICONV_TRANSLIT);
//     $raw_data = mb_str_replace('Factory Cart"!"', 'Factory Cart"', $raw_data);
//     $raw_data = mb_str_replace('"Fuel:', '"Fuel ', $raw_data);
    
//     echo "Detected encoding: "; var_dump(mb_detect_encoding($raw_data, null, strict: true));
     
//     echo "<BR><BR>";
     
//     print_r($raw_data);
     
//    echo "<BR><HR><BR>";

    $json_data = json_decode(
        $raw_data,
//        null,
//        512,
//        JSON_INVALID_UTF8_IGNORE | JSON_PARTIAL_OUTPUT_ON_ERROR | JSON_THROW_ON_ERROR
//        JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE | JSON_UNESCAPED_LINE_TERMINATORS | JSON_PARTIAL_OUTPUT_ON_ERROR 
    );
    /*echo match (json_last_error()) {
        JSON_ERROR_NONE => ' - No errors',
        JSON_ERROR_DEPTH => ' - Maximum stack depth exceeded',
        JSON_ERROR_STATE_MISMATCH => ' - Underflow or the modes mismatch',
        JSON_ERROR_CTRL_CHAR => ' - Unexpected control character found',
        JSON_ERROR_SYNTAX => ' - Syntax error, malformed JSON',
        JSON_ERROR_UTF8 => ' - Malformed UTF-8 characters, possibly incorrectly encoded',
        default => ' - Unknown error',
    };*/
//    echo "<BR><HR><BR>";
    print_r($json_data);
//    print_r(htmlspecialchars(file_get_contents('/var/www/html/storage/app/public/Docs.pretty.json'), ENT_IGNORE));
//    print_r(json_decode(utf8_encode(trim(Storage::disk('public')->get('Docs.json')))));
    /*$data->each(function ($item, $key) {
        
    });*/
});
