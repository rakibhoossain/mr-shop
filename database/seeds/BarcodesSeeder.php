<?php

use Illuminate\Database\Seeder;
use App\Barcode;

class BarcodesSeeder extends Seeder
{
	/**
     * @var array
     */
	protected $barcodes = [
		[
            'name'=>'20 Labels per Sheet - (8.5" x 11")',
            'description'=>'Sheet Size: 8.5" x 11"\r\nLabel Size: 4" x 1"\r\nLabels per sheet: 20',
            'width'=>3.75,
            'height'=>1,
            'paper_width'=>8.5,
            'paper_height'=>11,
            'top_margin'=>0.5,
            'left_margin'=>0.5,
            'row_distance'=>0.00,
            'col_distance'=>0.15625,
            'stickers_in_one_row'=>2,
            'is_default'=>0,
            'is_continuous'=>0,
            'stickers_in_one_sheet'=>20,
        ],
        [
            'name'=>'30 Labels per sheet - (8.5" x 11")',
            'description'=>'Sheet Size: 8.5" x 11"\r\nLabel Size: 2.625" x 1"\r\nLabels per sheet: 30',
            'width'=>2.625,
            'height'=>1,
            'paper_width'=>8.5,
            'paper_height'=>11,
            'top_margin'=>0.5,
            'left_margin'=>0.21975,
            'row_distance'=>0.00,
            'col_distance'=>0.14,
            'stickers_in_one_row'=>3,
            'is_default'=>0,
            'is_continuous'=>0,
            'stickers_in_one_sheet'=>30,
        ],
        [
            'name'=>'32 Labels per sheet - (8.5" x 11")',
            'description'=>'Sheet Size: 8.5" x 11"\r\nLabel Size: 2" x 1.25"\r\nLabels per sheet: 32',
            'width'=>2,
            'height'=>1.25,
            'paper_width'=>8.5,
            'paper_height'=>11,
            'top_margin'=>0.5,
            'left_margin'=>0.25,
            'row_distance'=>0.00,
            'col_distance'=>0,
            'stickers_in_one_row'=>4,
            'is_default'=>0,
            'is_continuous'=>0,
            'stickers_in_one_sheet'=>32,
        ],
        [
            'name'=>'40 Labels per sheet - (8.5" x 11")',
            'description'=>'Sheet Size: 8.5" x 11"\r\nLabel Size: 2" x 1"\r\nLabels per sheet: 40',
            'width'=>2,
            'height'=>1,
            'paper_width'=>8.5,
            'paper_height'=>11,
            'top_margin'=>0.5,
            'left_margin'=>0.25,
            'row_distance'=>0.00,
            'col_distance'=>0.00,
            'stickers_in_one_row'=>4,
            'is_default'=>0,
            'is_continuous'=>0,
            'stickers_in_one_sheet'=>40,
        ],
        [
            'name'=>'50 Labels per Sheet - (8.5" x 11")',
            'description'=>'Sheet Size: 8.5" x 11"\r\nLabel Size: 1.5" x 1"\r\nLabels per sheet: 50',
            'width'=>1.5,
            'height'=>1,
            'paper_width'=>8.5,
            'paper_height'=>11,
            'top_margin'=>0.5,
            'left_margin'=>0.5,
            'row_distance'=>0.00,
            'col_distance'=>0.00,
            'stickers_in_one_row'=>5,
            'is_default'=>0,
            'is_continuous'=>0,
            'stickers_in_one_sheet'=>50,
        ],
        [
            'name'=>'Continuous Rolls - 31.75mm x 25.4mm',
            'description'=>'Label Size: 31.75mm x 25.4mm\r\nGap: 3.18mm',
            'width'=>1.25,
            'height'=>1,
            'paper_width'=>1.25,
            'paper_height'=>0.00,
            'top_margin'=>0.125,
            'left_margin'=>0.00,
            'row_distance'=>0.125,
            'col_distance'=>0.00,
            'stickers_in_one_row'=>1,
            'is_default'=>0,
            'is_continuous'=>1,
            'stickers_in_one_sheet'=>null,
        ]
	];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->barcodes as $k => $barcode)
        {
        	$result = Barcode::create($barcode);
        	if (!$result) {
	            $this->command->info("Barcode Insert failed at $k.");
	            return;
            }
        }
        $this->command->info('Barcodes Inserted Successfully!');
    }
}
