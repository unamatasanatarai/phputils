<?php
/**
 * @version 1.0
 */
if (!class_exists('FileName')) {
    class FileName{

    	static public function slug($folder, $name){

    		$file = new File($folder . $name, false);
    		$ext = '.' . $file->ext();

    		$slug = $slug_proto = strtolower(
    			Inflector::slug($file->name())
    		);

    		$i = 0;
    		$r = true;
    		while($r){
    			$r = file_exists($folder . $slug . $ext);
    			if ($r){
    				$i++;
    				$slug = $slug_proto . '-' . $i;
    			}
    		}
    		return $slug . $ext;

    	}
    }
}
