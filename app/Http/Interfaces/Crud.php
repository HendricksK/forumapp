<?php 

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface Crud 
{
    public function get(Request $request);
    public function create(Request $request);
    public function update(Request $request);
    public function delete(Request $request);
}