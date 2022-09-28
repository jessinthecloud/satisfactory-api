<?php

namespace App\Services\Parsers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class DocsParser
{
    protected ?string $filename;
    protected Collection $data;

    public function __construct($filename = null, $data = null)
    {
        $this->filename = $filename ?? storage_path('app/public') . DIRECTORY_SEPARATOR . 'Docs-fixed.json';

        $cache_key = $data ?? Str::afterLast($this->filename, '/');

        $this->data = Cache::remember($cache_key, 300, function () {
            $data = collect(json_decode(file_get_contents($this->filename)));
            $this->prepare($data);
            return $data;
        });
        
        $this->parse();
    }

    private function prepare(Collection $data) : void
    {
        $data->transform(function ($definition, $key) {
            $definition->fqcn       = Str::between($definition->NativeClass, "Class'", "'");
            $definition->shortClass = Str::remove('/Script/FactoryGame.FG', $definition->fqcn);
            $definition->shortName  = implode(' ', Str::ucsplit($definition->shortClass));

            // note this so that we can determine the parser to use more easily
            $definition->parserClass = $this->identifyParser($definition->fqcn);

            return $definition;
        });
    }

    private function identifyParser(string $fqcn) : ?string
    {
        return match (true) {
            // parse buildings
            str_contains($fqcn, "Buildable") => BuildingParser::class,
//            str_contains($fqcn, "Recipe") => RecipeParser::class,
            // todo: parse descriptors
    
            // todo: parse recipes
    
            // todo: parse items (resources?)
    
            // todo: parse schematics
            default => null,
        };
    }

    public function parse()
    {
        $this->data->each(function ($definition) {
            $parser = !empty($definition->parserClass) ? new $definition->parserClass() : null;
            if(empty($parser)){
                // skip
                return;
            }
//            dump($definition);
            foreach($definition->Classes as $class){
                $thing = $parser->parse($class);
                dd($thing);
            };
        });

        


    }

    public function print() : void
    {
        echo "<body 
            style='background:#111; color:#eee; padding: 2rem; max-width:70rem; margin:0 auto'
        >";
        echo "<ul style='list-style: none;'>";

        $all_props = [];
        foreach ( $this->data as $data_row ) {
            echo "<li>NATIVE: <strong>{$data_row->shortClass} : </strong><BR>";
            if ( !Str::contains($data_row->shortClass, 'Buildable')
                && !Str::contains($data_row->shortClass, 'Descriptor')
                && !Str::contains($data_row->shortClass, 'Recipe')
                && !in_array($data_row->shortClass, [
                    'Schematic',
                    'ChargeWeapon',
                    'Weapon',                        
                ])
            ) {
                continue;
            }
            echo "<ul>";
            foreach ( $data_row->Classes as $class ) {
                echo "<li>{$class->ClassName}";
                $properties                    = array_keys(get_object_vars($class));
                $all_props [$class->ClassName] = [$properties];
                dump($properties);
                /*echo "<ul>";
                    foreach($properties as $property){
                        echo "<li>{$property}</li>";
                    }
                echo "</ul>";*/
                echo "</li>";
            } // end each class
            echo "</ul>";
//                    $countvals = array_count_values($all_props);
//                    $univals = array_unique($countvals, SORT_NUMERIC);
//            echo "<pre>";
//            print_r($all_props);
//            echo "</pre>";
            echo "</li>";
        } // end each native class
        echo "</ul>";

        echo "<pre>";
        print_r($all_props);
        echo "</pre>";

        echo "</body>";
    } // end print
}