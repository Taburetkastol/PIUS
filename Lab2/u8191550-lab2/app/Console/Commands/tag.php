<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class tag extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tag:count {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Returns number of articles binded to {id} tag';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tag_id = $this->argument('id');
        $count = DB::table('articles')
                            ->select('tags.name')
                            ->leftJoin('articles_tags', 'articles_tags.article_id', '=', 'articles.id')
                            ->join('tags', 'articles_tags.tag_id', '=', 'tags.id')
                            ->where('tags.id', 'LIKE', $tag_id)
                            ->get();
        $count = count($count);
        $this->line($count);
        return $count;
    }
}
