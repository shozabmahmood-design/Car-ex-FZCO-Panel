<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ExpensesCategory;

class Expense extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(ExpensesCategory::class, 'expenses_categories_id');
    }
}
