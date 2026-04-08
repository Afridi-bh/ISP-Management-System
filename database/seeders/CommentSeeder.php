<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $comments = [
            [
                'comment' => 'আমরা আপনার সমস্যা দেখছি। টেকনিশিয়ান পাঠানো হবে আজকের মধ্যে।',
                'user_id' => 1,
                'ticket_id' => 1,
            ],
            [
                'comment' => 'ধন্যবাদ। কখন আসবেন টেকনিশিয়ান?',
                'user_id' => 2,
                'ticket_id' => 1,
            ],
            [
                'comment' => 'আপনার রাউটার চেক করা হয়েছে। সিগন্যাল লেভেল কম ছিল। এখন ঠিক করা হয়েছে।',
                'user_id' => 1,
                'ticket_id' => 2,
            ],
            [
                'comment' => 'আপনার প্যাকেজ আপগ্রেড করা হয়েছে। নতুন স্পিড পাবেন আগামীকাল থেকে।',
                'user_id' => 1,
                'ticket_id' => 3,
            ],
        ];

        foreach ($comments as $comment) {
            Comment::create($comment);
        }
    }
}