<?php declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AdsTable extends AbstractMigration
{
    /**
     * Create `ad` table
     */
    public function up() 
    {
        $existsAdsTable = $this->hasTable('ads');
        if (!$existsAdsTable) {
            $table = $this->table('ads');
            $table->addColumn('text', 'string', ['null' => false, 'default' => ''])
                ->addColumn('price', 'integer', ['null' => true])
                ->addColumn('limit', 'integer', ['null' => true])
                ->addColumn('banner', 'string', ['null' => false, 'default' => ''])
                ->insert([
                    ['text' => 'Advertisement1', 'price' => 300, 'limit' => 1000, 'banner' => 'https://linktoimage1.png'],
                    ['text' => 'Advertisement2', 'price' => 400, 'limit' => 1500, 'banner' => 'https://linktoimage2.png'],
                    ['text' => 'Advertisement3', 'price' => 500, 'limit' => 2000, 'banner' => 'https://linktoimage3.png'],
                    ['text' => 'Advertisement4', 'price' => 600, 'limit' => 2500, 'banner' => 'https://linktoimage4.png']
                ])->create();
        }
    }

    public function down()
    {
        $existsAdsTable = $this->hasTable('ads');
        if ($existsAdsTable) {
            $this->table('ads')->drop()->save();
        }
    }
}
