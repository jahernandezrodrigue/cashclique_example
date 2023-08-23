<?php

namespace App\Http\Livewire\Temporal\Questions;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Question;
use DB, Log;

class IndexQuestions extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Question $question;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteQuestion' => 'delete'];

    public function render()
    {
        $query = Question::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $questions = $query->paginate($this->cant);
        return view('livewire.temporal.questions.index-questions', compact('questions'));
    }

    public function order($sort)
    {
        if ($this->sort==$sort)
        {
            if ($this->direction=='desc'){
                $this->direction='asc';
            }
            else{
                $this->direction='desc';
            }

        } else {
            $this->sort=$sort;
            $this->direction=='asc';
        }
    }

    public function delete(Question $question) {
        DB::beginTransaction();
        try {
            $question->delete();

            // Commit Transaction
            DB::commit();

            $this->emit('alert');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        }
    }
}
