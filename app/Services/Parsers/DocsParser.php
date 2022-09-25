<?php

namespace App\Services\Parsers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class DocsParser
{
    protected ?string $filename;
    protected Collection $data;
    
    public function __construct($filename = null, $data = null) {
        $this->filename = $filename ?? storage_path('app/public') . DIRECTORY_SEPARATOR . 'Docs-fixed.json';
        
        $cache_key = $data ?? Str::afterLast($this->filename, '/');
        
        $this->data = Cache::remember($cache_key, 300, function () {
            return collect(json_decode(file_get_contents($this->filename)));
        });
        
        $this->prepare();
    }

    private function prepare() : void
    {
        $this->data->transform(function($item, $key){
            $item->fqcn = Str::between($item->NativeClass, "Class'", "'");
            $item->shortClass = Str::remove('/Script/FactoryGame.FG', $item->fqcn);
            $item->shortName = implode(' ', Str::ucsplit($item->shortClass));

            return $item;
        });
    }

    public function print() : void
    {
        echo "<body 
            style='background:#111; color:#eee; padding: 2rem; max-width:70rem; margin:0 auto'
        >";
            echo "<ul style='list-style: none;'>";
            foreach($this->data as $data_row){
                echo "<li><strong>{$data_row->shortClass} : </strong><BR>";
                if( !Str::contains($data_row->shortClass, 'Buildable')
                    && !Str::contains($data_row->shortClass, 'Descriptor')
                    && !Str::contains($data_row->shortClass, 'Recipe')
                    && !in_array($data_row->shortClass, [
                        'Schematic',
                        'ChargeWeapon',
                        'Weapon',                        
                    ])
                ){
                    continue;
                }
                    echo "<ul>";
                        foreach($data_row->Classes as $class){
                            echo "<li>{$class->ClassName}";
                            $properties = array_keys(get_object_vars($class));
                                echo "<ul>";
                                    foreach($properties as $property){
                                        echo "<li>{$property}</li>";
                                    }
                                echo "</ul>";
                            echo "</li>";
                        }
                    echo "</ul>";
                echo "</li>";
            }
            echo "</ul>";
            
        echo "</body>";
    } // end print
}