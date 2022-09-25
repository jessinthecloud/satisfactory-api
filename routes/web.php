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
//    Cache::flush();
echo "<body style='background:#111; color:#eee; padding: 2rem; max-width:70rem; margin:0 auto'>";
    $data = Cache::remember('raw-game-data', 300, function () {
//        $raw_data = file_get_contents('/var/www/html/storage/app/public/Docs-fixed.json');
//        $json_data = json_decode($raw_data);
        return collect(json_decode(Storage::disk('public')->get('Docs-fixed.json')));
    });
    
    $data->transform(function($item, $key){
        $fqcn = Str::between($item->NativeClass, "Class'", "'");
        $item->fqcn = $fqcn;
        $class_name = Str::remove('/Script/FactoryGame.FG', $fqcn);
        $item->shortClass = $class_name;
        return $item;
    });
    
   /* $native_class_names = $data->pluck('NativeClass')->sort()->all();
    // Native classes
    echo "<table>".PHP_EOL;
    echo "<tr><th>Name</th><th>FQCN</th></tr>".PHP_EOL;
    foreach($native_class_names as $class_name_string){
        $fqcn = Str::between($class_name_string, "Class'", "'");
        $class_name = Str::remove('/Script/FactoryGame.FG', $fqcn);
//        $class_name = implode(' ', Str::ucsplit($class_name));
        echo "<tr><td>$class_name</td><td>$fqcn</td></tr>".PHP_EOL;
    }
    echo "</table>".PHP_EOL;*/

//    dump($data->first());
    $important_classes = [
//        "BuildableConveyorBelt",
//        "Recipe",
//        "BuildableResourceExtractor",
//        "BuildableFrackingExtractor",
//        "BuildableGeneratorFuel",
//        "BuildableManufacturer",
//        "BuildableManufacturerVariablePower",
//        "BuildableStorage",
    ];

    echo "<ul style='list-style: none;'>";
    foreach($data as $data_row){
        echo "<li><strong>{$data_row->shortClass} : </strong><BR>";
        if(!in_array($data_row->shortClass, $important_classes) 
//            && !Str::contains($data_row->shortClass, 'Descriptor')
//            && !Str::contains($data_row->shortClass, 'Buildable')
//            && !Str::contains($data_row->shortClass, 'Resource')
            && $data_row->shortClass !== 'Recipe'
        ){
            continue;
        }
            echo "<ul>";
                foreach($data_row->Classes as $class){
                    echo "<li>{$class->ClassName}";
                    $properties = array_keys(get_object_vars($class));
//                    if($data_row->shortClass !== 'Recipe'){
                        dump($class);
//                    } 
//                        echo "<ul>";
//                            foreach($properties as $property){
//                                echo "<li>{$property}</li>";
//                            }
//                        echo "</ul>";
                    echo "</li>";
                }
            echo "</ul>";
        echo "</li>";
    }
    echo "</ul>";
    
    echo "</body>";
});

