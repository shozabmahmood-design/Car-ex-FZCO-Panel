<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Expense;

class ExpensesCategory extends Model
{
    use HasFactory;

    public function expenses(){
        return $this->hasMany(Expense::class, 'expenses_categories_id');
    }
}
