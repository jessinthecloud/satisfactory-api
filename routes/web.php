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
    $data = Cache::remember('raw-game-data', 300, function () {
//        $raw_data = file_get_contents('/var/www/html/storage/app/public/Docs-fixed.json');
//        $json_data = json_decode($raw_data);
        return collect(json_decode(Storage::disk('public')->get('Docs-fixed.json')));
    });
//    dump(array_values($data->pluck('NativeClass')->map(function($item, $key){
//        return Str::remove('Class\'/Script/FactoryGame.FG', $item);
//    })->sort()->all()));
    
    $data->transform(function($item, $key){
        $fqcn = Str::between($item->NativeClass, "Class'", "'");
        $item->fqcn = $fqcn;
        $class_name = Str::remove('/Script/FactoryGame.FG', $fqcn);
        $item->shortClass = $class_name;
        return $item;
    });
    
//    dd($data->first());
    
    $native_class_names = $data->pluck('NativeClass')->sort()->all();
    // Native classes
    echo "<table>";
    echo "<tr><th>Name</th><th>FQCN</th></tr>";
    foreach($native_class_names as $class_name_string){
        $fqcn = Str::between($class_name_string, "Class'", "'");
        $class_name = Str::remove('/Script/FactoryGame.FG', $fqcn);
//        $class_name = implode(' ', Str::ucsplit($class_name));
        echo "<tr><td>$class_name</td><td>$fqcn</td></tr>";
    }
    echo "</table>";

//    dump($data->first());
    $important_classes = [
        "Recipe",
        "BuildableManufacturer",
        "BuildableFrackingExtractor"
    ];
//    dump($data->filter(function ($value, $key) use ($important_classes) {
//        return Str::contains($value->NativeClass, $important_classes, true);
//    })->all());
    echo "<ul style='list-style: none;'>";
    foreach($data as $data_row){
        if(!in_array($data_row->shortClass, $important_classes)){
            continue;
        }
        echo "<li><strong>{$data_row->fqcn} : </strong><BR>";
//            dump(array_column($data_row->Classes, 'ClassName'));
            echo "<ul>";
                foreach($data_row->Classes as $class){
//                var_dump($class);
                    echo "<li>{$class->ClassName} <BR>";
                    $properties = array_keys(get_object_vars($class));
                    if($data_row->shortClass !== 'Recipe'){
                        dump($properties);
//                        dump($class);
                    } 
                    echo "<BR></li>";
                }
            echo "</ul>";
        echo "</li>";
    }
    echo "</ul>";

//    $raw_data = file_get_contents('/var/www/html/storage/app/public/Docs-fixed.json');
//    $json_data = json_decode($raw_data);
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
//    dump($json_data);
//    print_r($json_data);

    /*$data->each(function ($item, $key) {
        
    });*/
});
