<?php use App\Models\SurgicalProcedure; SurgicalProcedure::where('type', 'Surgical')->update(['anaesthetist_percentage' => 40.00]); echo 'Done!';
