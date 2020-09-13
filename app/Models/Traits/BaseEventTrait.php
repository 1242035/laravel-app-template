<?php

namespace App\Models\Traits;

trait BaseEventTrait
{
    public static function retrieved( $model )
    {
        self::raise('retrieved', $model);
    }

    public static function creating( $model )
    {
        self::raise('creating', $model);
    }
    
    public static function created( $model )
    {
        self::raise('created', $model);
    }
    
    public static function updating( $model )
    {
        self::raise('updating', $model);
    }
    
    public static function updated( $model )
    {
        self::raise('updated', $model);
    }
    
    public static function saving( $model )
    {
        self::raise('saving', $model);
    }
    
    public static function saved( $model )
    {
        self::raise('saved', $model);
    }
    
    public static function deleting( $model )
    {
        self::raise('deleting', $model);
    }
    
    public static function deleted( $model )
    {
        self::raise('deleted', $model);
    }
    
    public static function restoring( $model )
    {
        self::raise('restoring', $model);
    }
    
    public static function restored( $model )
    {
        self::raise('restored', $model);
    }

    public static function raise($method, $model)
    {
        $className = get_class($model);
        $classEvent = '\\App\\Events\\Models\\' . $className . ucfirst($method);
        if (class_exists($classEvent)) {
            event(new $classEvent( $model ));
        }
    }
}
