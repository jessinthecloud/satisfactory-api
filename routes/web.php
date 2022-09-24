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
    $data = Cache::remember('raw-data', 300, function () {
        return collect(json_decode(Storage::disk('public')->get('data.json')));
    });

    $categories = array_values(collect($data['buildings'])->pluck('categories')->filter()->flatten()->unique()->sort()->all());
    echo "Categories: <ul>"; 
    foreach($categories as $category){
        $catname = implode(' ', Str::ucSplit(Str::betweenFirst($category, '_', '_')));
        echo "<li>$category ($catname)</li>";
    }
    echo "</ul>";
    
     echo "<BR><BR>";
    
    /*foreach($data['buildings'] as $building){
        echo "Name: {$building->name}<BR>";
        echo "Categories: ".print_r($building->categories, true)."<BR>";
        echo "Data: "; dump($building); echo "<BR>";
        echo "<BR>";
    }*/
    
//    dd($data->all());
    dump($data->all());
    // Transport
    // Truck
    dump($data->all()['recipes']->Recipe_TruckStation_C, $data->all()['buildings']->Desc_TruckStation_C, $data->all()['buildings']->Desc_Truck_C);
    // Hard Drive
//    dump($data->all()['schematics']->Research_HardDrive_0_C, $data->all()['items']->Desc_HardDrive_C); // maps to this item but it doesn't exist
    // Battery
//    dump($data->all()['recipes']->Recipe_Battery_C, $data->all()['items']->Desc_Battery_C);
//    dump($data->all()['recipes']->Recipe_ResourceSink_C, $data->all()['buildings']->Desc_ResourceSink_C);
//    dump($data->all()['recipes']->Recipe_ResourceSinkShop_C, $data->all()['buildings']->Desc_ResourceSinkShop_C);
    // Equipment Workstation
    dump($data->all()['recipes']->Recipe_Workshop_C, $data->all()['buildings']->Desc_Workshop_C);
    // Workbench
    dump($data->all()['recipes']->Recipe_WorkBench_C, $data->all()['buildings']->Desc_WorkBench_C);
    // Equipment Item
    dump("Equipment Item:",$data->all()['recipes']->Recipe_XenoZapper_C, $data->all()['items']->BP_EquipmentDescriptorShockShank_C);
    // Compound Resource
    dump("Compound Item:", $data->all()['recipes']->Recipe_Motor_C, $data->all()['items']->Desc_Motor_C,);
    // Complex Resource
    dump("Complex Item:",$data->all()['recipes']->Recipe_SpaceElevatorPart_1_C, $data->all()['items']->Desc_SpaceElevatorPart_1_C,);
    // alt recipe
    dump("Alt Recipe Item:",$data->all()['recipes']->Recipe_Alternate_PlasticSmartPlating_C, $data->all()['items']->Desc_SpaceElevatorPart_1_C,);
    // Natural resource
    dump("Natural Resource: ", $data->all()['items']->Desc_Coal_C, $data->all()['resources']->Desc_Coal_C);
    // Building Item
    dump("Building Item:",$data->all()['recipes']->Recipe_ConveyorBeltMk1_C, $data->all()['buildings']->Desc_ConveyorBeltMk1_C);
    // Machine Building - Natural Resource
    dump("Miner Building: ", $data->all()['miners']->Build_MinerMk2_C, $data->all()['buildings']->Desc_MinerMk2_C);
    dump("Assembler Building: ", $data->all()['recipes']->Recipe_AssemblerMk1_C, $data->all()['buildings']->Desc_AssemblerMk1_C);
    dump("Oil Extractor Building: ", $data->all()['recipes']->Recipe_FrackingExtractor_C, $data->all()['buildings']->Desc_FrackingExtractor_C);
    dump("Oil Refinery Building: ", $data->all()['recipes']->Recipe_OilRefinery_C, $data->all()['buildings']->Desc_OilRefinery_C);
//    dump($data->all()['items']->Desc_AluminumIngot_C);

    
    $data->each(function ($item, $key) {
        
    });
    
});
