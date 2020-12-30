<?php

namespace App\Traits;

trait ModelRelationships
{
    public function deleteRelationships($relationships)
    {
        foreach ((array) $relationships as $relationship) {
            if (!$this->has($relationship)->exists()) {
                continue;
            }

            if($this->$relationship() instanceof \Illuminate\Database\Eloquent\Relations\BelongsToMany) {
                $this->$relationship()->detach();
            }

            $this->$relationship()->delete();
        }
    }
    
    public function deleteWithRelationships($relationships)
    {
        $this->deleteRelationships($relationships);

        $this->delete();
    }
}
