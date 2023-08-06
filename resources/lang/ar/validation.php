<?php
return [
    'required' => ' :attribute  حقل ادخال مطلوب',
    'confirmed' => ':attribute غير متوافقتان',
    'unique' => ':attribute مأخوذ بالفعل',
    'exists' => ':attribute غير موجود',
    'distinct' => ':attribute تم اخذ منها قيمتان متكررتان',
    'file' => ' :attribute لابد ان يكون ملف',
    'mimes' => ':attribute لابد ان يكون امتداد الملف :values.',
    'date' => ' :attribute لابد ان يكون تاريخ',
    'integer' => ' :attribute لابد ان يكون عدد',

    'min' => [
        'numeric' => ' :attribute لابد ان يكون علي الاقل :min.',
        'file' => ':attribute لابد ان يكون علي الاقل :min كيلو بايت.',
        'string' => ' :attribute لابد ان يكون علي الاقل :min احرف.',
        'array' => ' :attribute لابد ان يكون علي الاقل :min عنصر.',
    ],

];
