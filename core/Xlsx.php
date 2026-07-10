<?php
/**
 * Xlsx.php
 * ------------------------------------------------------------------
 * Helper ringan untuk export & import file Excel (.xlsx) TANPA
 * dependency composer/PhpSpreadsheet. Cukup pakai extension bawaan
 * PHP: ext-zip dan ext-simplexml (biasanya sudah aktif di semua
 * instalasi PHP standar/Coolify image).
 *
 * CARA PAKAI:
 *   require_once APP_PATH . '/core/Xlsx.php';
 *
 *   // Tulis xlsx
 *   $content = Xlsx::write(['Nama','Kelas'], [['Budi','XII RPL 1']]);
 *
 *   // Baca xlsx (baris pertama biasanya header, tinggal array_shift)
 *   $rows = Xlsx::read('/path/ke/file.xlsx');
 *
 * CATATAN:
 *   - Reader ini mengasumsikan 1 sheet (xl/worksheets/sheet1.xml),
 *     cukup untuk kasus import data anggota yang sederhana.
 *   - Semua cell ditulis sebagai teks (inlineStr) agar nomor HP / NIA
 *     yang punya angka 0 di depan tidak hilang formatnya.
 *
 * Taruh file ini di: app/core/Xlsx.php (atau folder helper lain yang
 * kamu pakai, sesuaikan path require_once-nya).
 * ------------------------------------------------------------------
 */

class Xlsx
{
    // ================================================================
    //  WRITE (untuk fitur EXPORT)
    // ================================================================
    public static function write(array $headers, array $rows): string
    {
        if (!class_exists('ZipArchive')) {
            throw new RuntimeException('Extension ZipArchive tidak aktif di server. Aktifkan ext-zip di PHP.');
        }

        $tmpFile = tempnam(sys_get_temp_dir(), 'xlsx_');
        $zip = new ZipArchive();
        $zip->open($tmpFile, ZipArchive::OVERWRITE | ZipArchive::CREATE);

        $zip->addFromString('[Content_Types].xml', self::contentTypes());
        $zip->addFromString('_rels/.rels', self::rootRels());
        $zip->addFromString('xl/workbook.xml', self::workbook());
        $zip->addFromString('xl/_rels/workbook.xml.rels', self::workbookRels());
        $zip->addFromString('xl/worksheets/sheet1.xml', self::sheetXml($headers, $rows));

        $zip->close();

        $content = file_get_contents($tmpFile);
        @unlink($tmpFile);

        return $content;
    }

    private static function contentTypes(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
             . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
             . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
             . '<Default Extension="xml" ContentType="application/xml"/>'
             . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
             . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
             . '</Types>';
    }

    private static function rootRels(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
             . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
             . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
             . '</Relationships>';
    }

    private static function workbook(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
             . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
             . '<sheets><sheet name="Anggota" sheetId="1" r:id="rId1"/></sheets>'
             . '</workbook>';
    }

    private static function workbookRels(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
             . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
             . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
             . '</Relationships>';
    }

    private static function sheetXml(array $headers, array $rows): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $xml .= '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">';
        $xml .= '<sheetData>';
        $xml .= self::rowXml(1, $headers);

        $r = 2;
        foreach ($rows as $row) {
            $xml .= self::rowXml($r, $row);
            $r++;
        }

        $xml .= '</sheetData></worksheet>';
        return $xml;
    }

    private static function rowXml(int $rowIndex, array $cells): string
    {
        $xml = '<row r="' . $rowIndex . '">';
        $col = 'A';
        foreach ($cells as $value) {
            $ref = $col . $rowIndex;
            $safe = htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
            $xml .= '<c r="' . $ref . '" t="inlineStr"><is><t xml:space="preserve">' . $safe . '</t></is></c>';
            $col++;
        }
        $xml .= '</row>';
        return $xml;
    }

    // ================================================================
    //  READ (untuk fitur IMPORT)
    // ================================================================
    public static function read(string $filePath): array
    {
        if (!class_exists('ZipArchive')) {
            throw new RuntimeException('Extension ZipArchive tidak aktif di server. Aktifkan ext-zip di PHP.');
        }

        $zip = new ZipArchive();
        if ($zip->open($filePath) !== true) {
            throw new RuntimeException('File .xlsx tidak dapat dibuka / rusak.');
        }

        // Shared strings (dipakai kalau file di-generate Excel/Google Sheets asli)
        $sharedStrings = [];
        $ssXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($ssXml !== false) {
            $ss = @simplexml_load_string($ssXml);
            if ($ss !== false) {
                foreach ($ss->si as $si) {
                    if (isset($si->t)) {
                        $sharedStrings[] = (string)$si->t;
                    } else {
                        $text = '';
                        foreach ($si->r as $run) {
                            $text .= (string)$run->t;
                        }
                        $sharedStrings[] = $text;
                    }
                }
            }
        }

        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        $zip->close();

        if ($sheetXml === false) {
            throw new RuntimeException('Sheet pertama tidak ditemukan di file .xlsx. Pastikan data ada di sheet pertama.');
        }

        $sheet = @simplexml_load_string($sheetXml);
        if ($sheet === false) {
            throw new RuntimeException('Gagal membaca struktur file .xlsx.');
        }

        $rows = [];
        foreach ($sheet->sheetData->row as $rowXml) {
            $rowData  = [];
            $colIndex = 0;

            foreach ($rowXml->c as $c) {
                $ref       = (string)$c['r'];
                $type      = (string)$c['t'];
                $colLetter = preg_replace('/[0-9]/', '', $ref);
                $target    = self::colLetterToIndex($colLetter);

                // isi kolom yang kosong/terlewat dengan string kosong
                while ($colIndex < $target) {
                    $rowData[] = '';
                    $colIndex++;
                }

                if ($type === 's') {
                    $idx   = (int)$c->v;
                    $value = $sharedStrings[$idx] ?? '';
                } elseif ($type === 'inlineStr') {
                    $value = (string)($c->is->t ?? '');
                } else {
                    $value = (string)($c->v ?? '');
                }

                $rowData[] = $value;
                $colIndex++;
            }

            $rows[] = $rowData;
        }

        return $rows;
    }

    private static function colLetterToIndex(string $col): int
    {
        $col   = strtoupper($col);
        $index = 0;
        for ($i = 0; $i < strlen($col); $i++) {
            $index = $index * 26 + (ord($col[$i]) - ord('A') + 1);
        }
        return $index - 1;
    }
}