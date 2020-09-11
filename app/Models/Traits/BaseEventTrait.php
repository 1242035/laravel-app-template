<?php

namespace App\Models\Traits;

trait BaseEventTrait
{
    public function retrieved()
    {
        $this->raise('retrieved');
    }

    public function creating()
    {
        $this->raise('creating');
    }
    
    public function created()
    {
        $this->raise('created');
    }
    
    public function updating()
    {
        $this->raise('updating');
    }
    
    public function updated()
    {
        $this->raise('updated');
    }
    
    public function saving()
    {
        $this->raise('saving');
    }
    
    public function saved()
    {
        $this->raise('saved');
    }
    
    public function deleting()
    {
        $this->raise('deleting');
    }
    
    public function deleted()
    {
        $this->raise('deleted');
    }
    
    public function restoring()
    {
        $this->raise('restoring');
    }
    
    public function restored()
    {
        $this->raise('restored');
    }

    protected function raise($method)
    {
        $className = get_class($this);
        $classEvent = '\\App\\Events\\Models\\' . $className . strtoupper($method);
        if (class_exists($classEvent)) {
            event(new $classEvent($this));
        }
    }
}
