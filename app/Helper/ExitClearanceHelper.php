<?php

namespace App\Helper;

use App\Models\ExitClearance;
use App\Models\ExitClearanceBulletin;
use App\Models\ExitClearanceCheckList;
use App\Models\ExitClearanceSignature;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExitClearanceHelper
{

    public static function getPDFObject()
    {
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $pdf = new \Mpdf\Mpdf([
            'fontDir' => array_merge($fontDirs, [
                storage_path() . '/app/public/files/fonts',
            ]),
            'fontdata' => $fontData + [ // lowercase letters only in font key
                "khmeroscontent" => [/* Khmer */
                    'R' => "KhmerOScontent.ttf",
                    'useOTL' => 0xFF,
                ],
                "khmerosmuol" => [/* Khmer */
                    'R' => "KhmerOSmuol.ttf",
                    'useOTL' => 0xFF,
                ],
                "khmerosmuollight" => [/* Khmer */
                    'R' => "KhmerOSmuollight.ttf",
                    'useOTL' => 0xFF,
                ],
                "khmerosmuolpali" => [/* Khmer */
                    'R' => "KhmerOSmuolpali.ttf",
                    'useOTL' => 0xFF,
                ],
            ],
            'mode' => 'UTF-8',
            'format' => 'A4',
            'default_font_size' => 0,
            'default_font' => '',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_header' => 10,
            'margin_footer' => 10,
            'orientation' => 'P',
            'autoScriptToLang' => false,
            'autoLangToFont' => true,
            'default_font' => 'frutiger',
        ]);

        return $pdf;
    }

    private static function getHTML($header, $checklist, $approvedSignatures)
    {
        return "<!DOCTYPE html>
        <html lang='en'>
        <head>
          <meta charset='UTF-8'>
          <meta name='viewport' content='width=device-width, initial-scale=1.0'>
          <title>Exit Clearance Form</title>

          <style>
            .text-right{
                text-align:right;
            }
            .text-left{
                text-align:left;
            }
            .text-center{
                text-align:center;
            }
            .text-middle{
                vertical-align:middle;
            }
            .text-justify{
                text-align:justify;
            }
            .item-border {
                border: 0.2px solid black;
                border-collapse: collapse;
                padding:5px;
            }
            .item-filled {
                background-color: lightgrey;
            }
            .item-underline {
                border-bottom: 1px dotted black;
                padding:5px;
            }
            .item-k-h{
                font-family:khmerosmuollight;
                font-size:18px;
            }
            .item-e-h{
                font-family:dejavuserif;
                font-size:18px;
            }
            .item-k-content{
                font-family:khmeroscontent;
                line-height:20px;
                font-size:12px;
            }
            .item-e-content{
                font-family:dejavuserif;
                line-height:16px;
                font-size:12px;
            }
            .item-signature-title{
                vertical-align:baseline;
            }
            .item-signature{
                height:100px;
                vertical-align:bottom;
            }
          </style>
        </head>
        <body>
            $header
            $checklist
            $approvedSignatures
        </body>
        </html>";
    }

    private static function getExitClearanceHeader($id)
    {
        $exit_clearance = ExitClearance::find($id);

        $str = "
        <table width='100%' cellpadding='0' cellspacing='0'>
            <tr>
                <td width='100%' class='item-border'>
                    <table width='100%'>
                        <tr>
                        <td width='80%'><img src='var:logo' style='height: 100px;' /></td>
                        <td width='20%'>
                            <table width='100%'>
                                <tr><td class='text-right'>Code:</td></tr>
                                <tr><td class='text-right'>Version 3.0</td></tr>
                            </table>
                        </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td width='100%' class='item-border'>
                    <table width='100%'>
                        <tr>
                            <td width='100%' class='text-center item-k-h'>
                                ទម្រង់ចាកចេញពីការងារ
                            </td>
                        </tr>
                        <tr>
                            <td class='text-center item-e-h'>
                                EXIT CLEARANCE FORM
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td width='100%' class='item-border'>
                    <table width='100%'>
                        <tr>
                            <td width='100%' class='text-justify item-k-content'>
                            ទម្រង់នេះ គឺនឹងត្រូវប្រើនៅពេលដែលបុគ្គលិកណាម្នាក់បានឈប់ពីការងារ។ ប្រធានផ្នែករបស់បុគ្គលិកត្រូវបំពេញទម្រង់នេះ ជាមួយផ្នែកដែលពាក់ព័ន្ធនៅថ្ងៃធ្វើការចុងក្រោយ ដើម្បីធានាថាបុគ្គលិកបានប្រគល់ទ្រព្យសម្បត្តិក្រុមហ៊ុន និងដោះស្រាយបញ្ហាដែលមិនទាន់ដោះស្រាយ មុនពេលដែលបានចុះហត្ថលេខា។ ទម្រង់ដែលបានបំពេញទាំងអស់ ត្រូវដាក់ជូនផ្នែកធនធានមនុស្ស មុនពេលការទូទាត់ប្រាក់ខែចុងក្រោយ។
                            </td>
                        </tr>
                        <tr>
                            <td class='text-justify item-k-content'>
                            This form is to be completed whenever any employee terminate his/her employment. Employee's line manager has to complete his/her employee's clearance with the related departments on his/her last employment in order to ensure that the employee returns all company's assets and solve outstanding matters before signing off. All duty completed forms should be submitted to the Human Resources Department before the last payment will be released.
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td width='100%' class='item-border'>
                    <table width='100%'>
                        <tr>
                            <td width='16%' class='text-left item-k-content'>
                                ឈ្មោះបុគ្គលិក/Name:
                            </td>
                            <td width='24%' class='text-left item-k-content item-underline'>
                                $exit_clearance->name
                            </td>
                            <td width='10%' class='text-left item-k-content'>
                                អត្តលេខ/ID:
                            </td>
                            <td width='10%' class='text-left item-k-content item-underline'>
                                $exit_clearance->card_id
                            </td>
                            <td width='11%' class='text-left item-k-content'>
                                តួនាទី/Position:
                            </td>
                            <td width='24%' class='text-left item-k-content item-underline'>
                                $exit_clearance->position
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width='100%' class='item-border'>
                    <table width='100%'>
                        <tr>
                            <td width='20%' class='text-left item-k-content'>
                                សាខា/ផ្នែក/Campus/Dept:
                            </td>
                            <td width='21%' class='text-left item-k-content item-underline'>
                                $exit_clearance->department
                            </td>
                            <td width='27%' class='text-left item-k-content'>
                                ឈ្មោះប្រធាន/Line Manager's Name:
                            </td>
                            <td width='32%' class='text-left item-k-content item-underline'>
                                $exit_clearance->line_management
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td width='100%' class='item-border'>
                    <table width='100%'>
                        <tr>
                            <td width='11%' class='text-left item-k-content'>
                                អ៊ីមែល/Email:
                            </td>
                            <td width='34%' class='text-left item-k-content item-underline'>
                                $exit_clearance->email
                            </td>
                            <td width='25%' class='text-left item-k-content'>
                                ទូរស័ព្ទទំនាក់ទំនង/Cellular Phone:
                            </td>
                            <td width='30%' class='text-left item-k-content item-underline'>
                                $exit_clearance->phone
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width='100%' class='item-border'>
                    <table width='100%'>
                        <tr>
                            <td width='20%' class='text-left item-k-content'>
                                ថ្ងៃចូលធ្វើការ/Date of Hire:
                            </td>
                            <td width='30%' class='text-left item-k-content item-underline'>
                               " . Carbon::parse($exit_clearance->hired_date)->isoFormat('MMM DD, YYYY') . "
                            </td>
                            <td width='20%' class='text-left item-k-content'>
                                ថ្ងៃបញ្ចប់ការងារ/Last Date:
                            </td>
                            <td width='30%' class='text-left item-k-content item-underline'>
                               " . Carbon::parse($exit_clearance->last_working_date)->isoFormat('MMM DD, YYYY') . "
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
            ";
        return $str;
    }

    private static function getExitClearanceCheckList($checklistdata)
    {
        $strCheckListStr = "";

        $i = 0;
        foreach ($checklistdata as $bulitin) {
            $i = $i + 1;
            $strCheckListStr = "<div>$strCheckListStr
                                <tr>
                                    <td class='text-center item-border item-k-content '>
                                        " . $bulitin['bulletin']->value . "</td>
                                    <td colspan='3' class='text-left item-border item-k-content '>
                                        " . $bulitin['bulletin']->name_kh . "/" . $bulitin['bulletin']->name_en . "
                                    </td>
                                </tr>
                                ";

            foreach ($bulitin['checklists'] as $subCheckList) {
                $signatureField = ($subCheckList->is_checked === "Checked" || $subCheckList->is_checked === "Unavailable" ?
                    "<table>
                    <tr>
                        <td>
                            <img src='var:$subCheckList->checked_code" . "_" . "$subCheckList->id' style='height: 25px' />
                        </td>
                        <td class='item-k-content'>
                            $subCheckList->emp_name
                        </td>
                    </tr>
                </table>" : "<table>
                <tr>
                    <td>

                    </td>
                    <td class='item-k-content' style='color:red'>
                        $subCheckList->emp_name
                    </td>
                </tr>
            </table>");

                $strCheckListStr = "$strCheckListStr
                <tr>
                    <td class='text-center item-border item-k-content'>
                        " . $subCheckList->ordinal . "</td>
                    <td  class='text-left item-border item-k-content'>
                        " . $subCheckList->name_kh . "/" . $subCheckList->name_en . "
                    </td>
                    <td  class='item-border item-k-content'>
                        <table>
                            <tr>
                                <td><img src='var:" . ($subCheckList->is_checked === "Unavailable" ? "check_box_cross" : ($subCheckList->is_checked === "Checked" ? "check_box_filled" : "check_box_outline")) . "' " . ($subCheckList->is_checked === "Unavailable" ? "style='height:18.5px;width:18.5px;margin-left:3px'" : "style='height:23px;width:23px'") . " /></td>
                                <td class='item-k-content'>" . ($subCheckList->is_checked === "Unavailable" ? "មិនមាន/Unavailable" : "រួចរាល់/Completed") . "</td>
                            <tr>
                        </table>
                    </td>
                    <td  class='text-left item-border item-k-content'>
                        $signatureField
                    </td>
                </tr>";
            }

            $strCheckListStr = "$strCheckListStr</div>";
        }

        $str = "<table width='100%' cellpadding='0' cellspacing='0'>
                <tr>
                    <td class='text-center item-border item-k-content item-filled'>
                        ល.រ <br />
                        Nº
                    </td>
                    <td class='text-center item-border item-k-content item-filled'>
                        ការពិពណ៌នាអំពីវត្ថុ <br />
                        Item Description
                    </td>
                    <td class='text-center item-border item-k-content item-filled'>
                        ស្ថានភាពត្រួតពិនិត្យ <br />
                        Verification Status
                    </td>
                    <td class='text-center item-border item-k-content item-filled'>
                        ហត្ថលេខា និងឈ្មោះអ្នកទទួលខុសត្រូវ <br />
                        Name and Signature of Responsible Person
                    </td>
                </tr>
                $strCheckListStr
            </table>";
        return $str;
    }

    private static function attachSignature($id, $pdf)
    {
        $checklist = DB::select("select
                        eccl.id,
                        eccl.checked_id,
                        eccl.checked_code,
                        eccl.is_checked
                    from exit_clearance_bulletins ecb inner join exit_clearance_check_lists eccl
                    on ecb.id=eccl.bulletin_id
                    where eccl.deleted_at is null and ecb.deleted_at is null and ecb.exit_id=?", [$id]);

        for ($i = 0; $i < count($checklist); $i++) {
            if ($checklist[$i]->is_checked === "Checked" || $checklist[$i]->is_checked === "Unavailable") {
                if (Storage::disk('local')->exists("/public/files/signatureimg/" . $checklist[$i]->checked_id . ".jpg")) {
                    $pdf->imageVars[$checklist[$i]->checked_code . '_' . $checklist[$i]->id] = file_get_contents(base_path("storage/app/public/files/signatureimg/" . $checklist[$i]->checked_id . ".jpg"));
                } else {
                    $pdf->imageVars[$checklist[$i]->checked_code . '_' . $checklist[$i]->id] = file_get_contents(base_path("storage/app/public/files/signatureimg/noSignature.png"));
                }
            }
        }
    }

    private static function getApprovedSignature($id, $pdf)
    {
        $approvedSignatures = ExitClearanceSignature::where('exit_id', $id)->get();

        $signatures = array();

        foreach ($approvedSignatures as $signature) {
            if ($signature->is_signed === true) {
                if (Storage::disk('local')->exists("/public/files/signatureimg/" . $signature->signed_id . ".jpg")) {
                    $pdf->imageVars[$signature->signed_id . '_' . $signature->id . '_' . 'approval'] = file_get_contents(base_path("storage/app/public/files/signatureimg/" . $signature->signed_id . ".jpg"));
                } else {
                    $pdf->imageVars[$signature->signed_id . '_' . $signature->id . '_' . 'approval'] = file_get_contents(base_path("storage/app/public/files/signatureimg/noSignature.png"));
                }
            }

            if ($signature->sign_title === "Personnel Officer") {
                $signatures["Personnel Officer"] = ['signed_code' => $signature->signed_code, 'emp_name' => $signature->emp_name, 'position' => $signature->position, 'sign_img' => $signature->signed_id . '_' . $signature->id . '_' . 'approval', "signed_date" => $signature->signed_date, 'is_signed' => $signature->is_signed];
            } else if ($signature->sign_title === "Line Manager") {
                $signatures["Line Manager"] = ['signed_code' => $signature->signed_code, 'emp_name' => $signature->emp_name, 'position' => $signature->position, 'sign_img' => $signature->signed_id . '_' . $signature->id . '_' . 'approval', "signed_date" => $signature->signed_date, 'is_signed' => $signature->is_signed];
            } else if ($signature->sign_title === "Employee") {
                $signatures["Employee"] = ['signed_code' => $signature->signed_code, 'emp_name' => $signature->emp_name, 'position' => $signature->position, 'sign_img' => $signature->signed_id . '_' . $signature->id . '_' . 'approval', "signed_date" => $signature->signed_date, 'is_signed' => $signature->is_signed];
            } else if ($signature->sign_title === "HOD") {
                $signatures["HOD"] = ['signed_code' => $signature->signed_code, 'emp_name' => $signature->emp_name, 'position' => $signature->position, 'sign_img' => $signature->signed_id . '_' . $signature->id . '_' . 'approval', "signed_date" => $signature->signed_date, 'is_signed' => $signature->is_signed];
            } else if ($signature->sign_title === "HR Dept") {
                $signatures["HR Dept"] = ['signed_code' => $signature->signed_code, 'emp_name' => $signature->emp_name, 'position' => $signature->position, 'sign_img' => $signature->signed_id . '_' . $signature->id . '_' . 'approval', "signed_date" => $signature->signed_date, 'is_signed' => $signature->is_signed];
            } else if ($signature->sign_title === "CD") {
                $signatures["CD"] = ['signed_code' => $signature->signed_code, 'emp_name' => $signature->emp_name, 'position' => $signature->position, 'sign_img' => $signature->signed_id . '_' . $signature->id . '_' . 'approval', "signed_date" => $signature->signed_date, 'is_signed' => $signature->is_signed];
            } else if ($signature->sign_title === "Principal") {
                $signatures["Principal"] = ['signed_code' => $signature->signed_code, 'emp_name' => $signature->emp_name, 'position' => $signature->position, 'sign_img' => $signature->signed_id . '_' . $signature->id . '_' . 'approval', "signed_date" => $signature->signed_date, 'is_signed' => $signature->is_signed];
            }
        }

        $str = "<table width='100%' cellpadding='0' cellspacing='0'>
        <tr>
            <td width='50%' class='item-border'>
                <table>
                    <tr>
                        <td colspan='2' class='item-k-content item-signature-title'>
                            រៀបចំដោយ/Prepared by:
                        </td>
                    </tr>
                    <tr>
                        <td class='item-underline item-signature' width='35%;'>" .
            ($signatures["Personnel Officer"]["is_signed"] ? "<img src='var:" . $signatures["Personnel Officer"]["sign_img"] . "' style='height: 65px;' />" : "<br /><br />") . "<br />" .
            $signatures["Personnel Officer"]["emp_name"]
            . "</td>
                        <td width='30%'>
                        </td>
                        <td class='item-underline' width='35%' style='vertical-align:bottom'>" .
            ($signatures["Personnel Officer"]["is_signed"] ? Carbon::parse($signatures["Personnel Officer"]["signed_date"])->isoFormat('MMM DD, YYYY') : "") . "
                        </td>
                    </tr>
                    <tr>
                        <td class='item-k-content' width='35%'>
                            មន្ត្រីទទួលបន្ទុក <br />
                            Personal Office
                        </td>
                        <td width='30%'>
                        </td>
                        <td class='item-k-content' width='35%'>
                            កាលបរិច្ឆេទ <br />
                            Date
                        </td>
                    </tr>
                </table>
            </td>
            <td width='50%' class='item-border'>
                <table>
                    <tr>
                        <td colspan='2' class='item-k-content item-signature-title'>
                            ត្រួតពិនិត្យដោយ/Check by:
                        </td>
                    </tr>
                    <tr>
                        <td class='item-underline item-signature' width='35%'>" .
            ($signatures["Line Manager"]["is_signed"] ? "<img src='var:" . $signatures["Line Manager"]["sign_img"] . "' style='height: 65px;' />" : "<br /><br />") . "<br />" .
            $signatures["Line Manager"]["emp_name"] . "
                        </td>
                        <td width='30%'>
                        </td>
                        <td class='item-underline item-signature' width='35%'>" .
            ($signatures["Line Manager"]["is_signed"] ? Carbon::parse($signatures["Line Manager"]["signed_date"])->isoFormat('MMM DD, YYYY') : "")
            . "</td>
                    </tr>
                    <tr>
                        <td class='item-k-content' width='35%'>
                            ប្រធានគ្រប់គ្រងផ្ទាល់ <br />
                            Line Manager
                        </td>
                        <td width='30%'>
                        </td>
                        <td class='item-k-content' width='35%'>
                            កាលបរិច្ឆេទ <br />
                            Date
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td width='50%' class='item-border'>
                <table>
                    <tr>
                        <td colspan='3' class='item-k-content item-signature-title'>
                            ខ្ញុំសូមបញ្ជាក់ និងទទួលស្គាល់ថា ព័ត៌មាននៅក្នុងទម្រង់នេះ គឺជាការពិត និងត្រឹមត្រូវពិតប្រកដមែន។/I certify and acknowledge that the information in this form us true and completed.
                        </td>
                    </tr>
                    <tr>
                        <td class='item-underline item-signature' width='35%'>
                        " .
            ($signatures["Employee"]["is_signed"] ? "<img src='var:" . $signatures["Employee"]["sign_img"] . "' style='height: 65px;' />" : "<br /><br />") . "<br />" .
            $signatures["Employee"]["emp_name"] . "
                        </td>
                        <td width='30%'>
                        </td>
                        <td class='item-underline item-signature' width='35%'>" .
            ($signatures["Employee"]["is_signed"] ? Carbon::parse($signatures["Employee"]["signed_date"])->isoFormat('MMM DD, YYYY') : "")
            . "</td>
                    </tr>
                    <tr>
                        <td colspan='2' class='item-k-content'>
                            ហត្ថលេខា និងឈ្មោះបុគ្គលិក <br />
                            Employee's Signature and Name
                        </td>
                        <td class='item-k-content' width='35%'>
                            កាលបរិច្ឆេទ <br />
                            Date
                        </td>
                    </tr>
                </table>
            </td>
            <td width='50%' class='item-border'>
                <table>
                    <tr>
                        <td colspan='3' class='item-k-content item-signature-title'>
                            អនុម័តដោយ ប្រធានផ្នែក ឬអ្នកតំណាង/Endorsed by HoD or Authorized Representative <br /> <br /> <br />
                        </td>
                    </tr>
                    <tr>
                        <td class='item-underline item-signature' width='35%'>
                        " .
            ($signatures["HOD"]["is_signed"] ? "<img src='var:" . $signatures["HOD"]["sign_img"] . "' style='height: 65px;' />" : "<br /><br />") . "<br />" .
            $signatures["HOD"]["emp_name"]
            . "
                        </td>
                        <td width='30%'>
                        </td>
                        <td class='item-underline item-signature' width='35%'>
                        " . ($signatures["HOD"]["is_signed"] ? Carbon::parse($signatures["HOD"]["signed_date"])->isoFormat('MMM DD, YYYY') : "") . "
                        </td>
                    </tr>
                    <tr>
                        <td class='item-k-content' width='35%'>
                            ហត្ថលេខា និងឈ្មោះ <br />
                            Signature and Name
                        </td>
                        <td width='30%'>
                        </td>
                        <td class='item-k-content' width='35%'>
                            កាលបរិច្ឆេទ <br />
                            Date
                        </td>
                    </tr>
                </table>
            </td>
        </tr>";

        if (array_key_exists("CD", $signatures) && array_key_exists("Principal", $signatures)) {
            $str = "$str<tr>
                        <td width='50%' class='item-border'>
                            <table>
                                <tr>
                                    <td colspan='3' class='item-k-content item-signature-title'>
                                    អនុម័តដោយ នាយកសាលា ឬអ្នកតំណាង / Endorsed by Campus Director or Authorized <br /> <br /> <br />
                                    </td>
                                </tr>
                                <tr>
                                    <td class='item-underline item-signature' width='35%'>
                                    " .
                ($signatures["CD"]["is_signed"] ? "<img src='var:" . $signatures["CD"]["sign_img"] . "' style='height: 65px;' />" : "<br /><br />") . "<br />" .
                $signatures["CD"]["emp_name"] . "
                                    </td>
                                    <td width='30%'>
                                    </td>
                                    <td class='item-underline item-signature' width='35%'>" .
                ($signatures["CD"]["is_signed"] ? Carbon::parse($signatures["CD"]["signed_date"])->isoFormat('MMM DD, YYYY') : "")
                . "</td>
                                </tr>
                                <tr>
                                    <td colspan='2' class='item-k-content'>
                                        ហត្ថលេខា និងឈ្មោះបុគ្គលិក <br />
                                        Employee's Signature and Name
                                    </td>
                                    <td class='item-k-content' width='35%'>
                                        កាលបរិច្ឆេទ <br />
                                        Date
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width='50%' class='item-border'>
                            <table>
                                <tr>
                                    <td colspan='3' class='item-k-content item-signature-title'>
                                    អនុម័តដោយ ចាងហ្វាង ឬអ្នកតំណាង / Endorsed by Principle or Authorized <br /> <br /> <br />
                                    </td>
                                </tr>
                                <tr>
                                    <td class='item-underline item-signature' width='35%'>
                                    " .
                ($signatures["Principal"]["is_signed"] ? "<img src='var:" . $signatures["Principal"]["sign_img"] . "' style='height: 65px;' />" : "<br /><br />") . "<br />" .
                $signatures["Principal"]["emp_name"]
                . "
                                    </td>
                                    <td width='30%'>
                                    </td>
                                    <td class='item-underline item-signature' width='35%'>
                                    " . ($signatures["Principal"]["is_signed"] ? Carbon::parse($signatures["Principal"]["signed_date"])->isoFormat('MMM DD, YYYY') : "") . "
                                    </td>
                                </tr>
                                <tr>
                                    <td class='item-k-content' width='35%'>
                                        ហត្ថលេខា និងឈ្មោះ <br />
                                        Signature and Name
                                    </td>
                                    <td width='30%'>
                                    </td>
                                    <td class='item-k-content' width='35%'>
                                        កាលបរិច្ឆេទ <br />
                                        Date
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                ";
        } else if (array_key_exists("CD", $signatures) && !array_key_exists("Principal", $signatures)) {
            $str = "$str<tr>
                        <td width='50%' class='item-border'>
                            <table>
                                <tr>
                                    <td colspan='3' class='item-k-content item-signature-title'>
                                    អនុម័តដោយ នាយកសាលា ឬអ្នកតំណាង / Endorsed by Campus Director or Authorized <br /> <br /> <br />
                                    </td>
                                </tr>
                                <tr>
                                    <td class='item-underline item-signature' width='35%'>
                                    " .
                ($signatures["CD"]["is_signed"] ? "<img src='var:" . $signatures["CD"]["sign_img"] . "' style='height: 65px;' />" : "<br /><br />") . "<br />" .
                $signatures["CD"]["emp_name"] . "
                                    </td>
                                    <td width='30%'>
                                    </td>
                                    <td class='item-underline item-signature' width='35%'>" .
                ($signatures["CD"]["is_signed"] ? Carbon::parse($signatures["CD"]["signed_date"])->isoFormat('MMM DD, YYYY') : "")
                . "</td>
                                </tr>
                                <tr>
                                    <td colspan='2' class='item-k-content'>
                                        ហត្ថលេខា និងឈ្មោះបុគ្គលិក <br />
                                        Employee's Signature and Name
                                    </td>
                                    <td class='item-k-content' width='35%'>
                                        កាលបរិច្ឆេទ <br />
                                        Date
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width='50%' class='item-border'>
                            <table>
                                <tr>
                                    <td colspan='3' class='item-k-content item-signature-title'>
                                    អនុម័តដោយ ចាងហ្វាង ឬអ្នកតំណាង / Endorsed by Principle or Authorized <br /> <br /> <br />
                                    </td>
                                </tr>
                                <tr>
                                    <td class='item-underline item-signature' width='35%'>
                                    </td>
                                    <td width='30%'>
                                    </td>
                                    <td class='item-underline item-signature' width='35%'>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='item-k-content' width='35%'>
                                        ហត្ថលេខា និងឈ្មោះ <br />
                                        Signature and Name
                                    </td>
                                    <td width='30%'>
                                    </td>
                                    <td class='item-k-content' width='35%'>
                                        កាលបរិច្ឆេទ <br />
                                        Date
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                ";
        } else if (!array_key_exists("CD", $signatures) && array_key_exists("Principal", $signatures)) {
            $str = "$str<tr>
                            <td width='50%' class='item-border'>
                            <table>
                                <tr>
                                    <td colspan='3' class='item-k-content item-signature-title'>
                                    អនុម័តដោយ ចាងហ្វាង ឬអ្នកតំណាង / Endorsed by Principle or Authorized <br /> <br /> <br />
                                    </td>
                                </tr>
                                <tr>
                                    <td class='item-underline item-signature' width='35%'>
                                    " .
                ($signatures["Principal"]["is_signed"] ? "<img src='var:" . $signatures["Principal"]["sign_img"] . "' style='height: 65px;' />" : "<br /><br />") . "<br />" .
                $signatures["Principal"]["emp_name"]
                . "
                                    </td>
                                    <td width='30%'>
                                    </td>
                                    <td class='item-underline item-signature' width='35%'>
                                    " . ($signatures["Principal"]["is_signed"] ? Carbon::parse($signatures["Principal"]["signed_date"])->isoFormat('MMM DD, YYYY') : "") . "
                                    </td>
                                </tr>
                                <tr>
                                    <td class='item-k-content' width='35%'>
                                        ហត្ថលេខា និងឈ្មោះ <br />
                                        Signature and Name
                                    </td>
                                    <td width='30%'>
                                    </td>
                                    <td class='item-k-content' width='35%'>
                                        កាលបរិច្ឆេទ <br />
                                        Date
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width='50%' class='item-border'>
                            <table>
                                <tr>
                                    <td colspan='3' class='item-k-content item-signature-title'>
                                    អនុម័តដោយ នាយកសាលា ឬអ្នកតំណាង / Endorsed by Campus Director or Authorized <br /> <br /> <br />
                                    </td>
                                </tr>
                                <tr>
                                    <td class='item-underline item-signature' width='35%'>
                                    </td>
                                    <td width='30%'>
                                    </td>
                                    <td class='item-underline item-signature' width='35%'></td>
                                </tr>
                                <tr>
                                    <td colspan='2' class='item-k-content'>
                                        ហត្ថលេខា និងឈ្មោះបុគ្គលិក <br />
                                        Employee's Signature and Name
                                    </td>
                                    <td class='item-k-content' width='35%'>
                                        កាលបរិច្ឆេទ <br />
                                        Date
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                ";
        }

        $str = "$str<tr>
            <td width='50%' class='item-border'>
                <table>
                    <tr>
                        <td colspan='2' class='item-k-content item-signature-title'>
                            ទទួលដោយ/Received by:
                        </td>
                    </tr>
                    <tr>
                        <td class='item-underline item-signature' width='35%'>
                        " .
            ($signatures["HR Dept"]["is_signed"] ? "<img src='var:" . $signatures["HR Dept"]["sign_img"] . "' style='height: 65px;' />" : "<br /><br />") . "<br />" .
            $signatures["HR Dept"]["emp_name"]
            . "
                        </td>
                        <td width='30%'>
                        </td>
                        <td class='item-underline item-signature' width='35%'>
                        " . ($signatures["HR Dept"]["is_signed"] ? Carbon::parse($signatures["HR Dept"]["signed_date"])->isoFormat('MMM DD, YYYY') : "") . "
                        </td>
                    </tr>
                    <tr>
                        <td class='item-k-content' width='35%'>
                            ហត្ថលេខា និងឈ្មោះ <br />
                            Signature and Name
                        </td>
                        <td width='30%'>
                        </td>
                        <td class='item-k-content' width='35%'>
                            កាលបរិច្ឆេទ <br />
                            Date
                        </td>
                    </tr>
                </table>
            </td>
            <td width='50%' class='item-border' style='vertical-align: baseline'>
                <table>
                    <tr>
                        <td width='100%' class='item-k-content'>
                            សម្គាល់/Remark:
                        </td>
                    </tr>
                    <tr>
                        <td class='item-k-content' width='100%' >

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        </table>";

        return $str;
    }

    private static function getCheckList($exit_id)
    {
        $bulletins = DB::select("select
            ecb.id,
            ecb.emp_name,
            ecb.checked_id,
            b.id mvl_id,
            b.abbreviation,
            b.name_en,
            b.name_kh,
            b.\"type\",
            b.value,
            b.ordinal,
            b.parent_mvl
        from exit_clearance_bulletins ecb inner join mainvaluelists b
        on ecb.questionnaire=b.id
        where ecb.exit_id=? and ecb.deleted_at is null order by b.ordinal", [$exit_id]);

        $checklists = [];
        foreach ($bulletins as $bulletin) {
            $checklist = DB::select("select
                    eccl.id,
                    eccl.emp_name,
                    eccl.checked_id,
                    eccl.checked_code,
                    c.id mvl_id,
                    c.abbreviation,
                    c.name_en,
                    c.name_kh,
                    c.\"type\",
                    c.value,
                    c.ordinal,
                    c.parent_mvl,
                    eccl.is_checked
                from exit_clearance_check_lists eccl inner join mainvaluelists c
                on eccl.questionnaire=c.id
                where eccl.bulletin_id=? and eccl.deleted_at is null order by c.ordinal", [$bulletin->id]);
            $checklists[] = ["bulletin" => $bulletin, "checklists" => $checklist];
        }

        return $checklists;
    }

    public static function makeExitClearancePDF($id)
    {
        $pdf = ExitClearanceHelper::getPDFObject();
        $pdf->imageVars['logo'] = file_get_contents(base_path('storage/app/public/files/sysimg/mjqe.png'));
        $pdf->imageVars['check_box_filled'] = file_get_contents(base_path('storage/app/public/files/sysimg/check_box_fill.svg'));
        $pdf->imageVars['check_box_outline'] = file_get_contents(base_path('storage/app/public/files/sysimg/check_box_outline.svg'));
        $pdf->imageVars['check_box_cross'] = file_get_contents(base_path('storage/app/public/files/sysimg/check_box_cross.svg'));

        $exitClearnace = ExitClearance::find($id);
        $checklists = ExitClearanceHelper::getCheckList($id);

        ExitClearanceHelper::attachSignature($id, $pdf);
        $header = ExitClearanceHelper::getExitClearanceHeader($id);
        $checklist = ExitClearanceHelper::getExitClearanceCheckList($checklists);
        $approvedSignatures = ExitClearanceHelper::getApprovedSignature($id, $pdf);

        $str = ExitClearanceHelper::getHTML($header, $checklist, $approvedSignatures);

        if ($exitClearnace->is_rejected === true) {
            $pdf->SetWatermarkText('Rejected');
            $pdf->showWatermarkText = true;
        }

        $pdf->WriteHTML($str);
        $folderName = Carbon::parse($exitClearnace->last_working_date)->isoFormat('MMM_Do_YYYY');
        $lastWorkingDate = Carbon::parse($exitClearnace->last_working_date)->isoFormat('MMM Do, YYYY');
        $storePath = "/public/files/exit_clearance/" . $folderName;

        if (!Storage::exists($storePath)) {
            Storage::makeDirectory($storePath);
        }

        Storage::disk('local')->put($storePath . "/$id.pdf", $pdf->Output('', 'S'));

        return ["filePath" => "$folderName/$id.pdf", "lastWorkingDate" => $lastWorkingDate];
    }

    public static function bulletinComplete($id, $date)
    {
        $checklist = ExitClearanceCheckList::where('bulletin_id', $id)->where('is_checked', 'Unchecked')->get();

        if (count($checklist) === 0) {
            $bulletin = ExitClearanceBulletin::find($id);
            $bulletin->completed_date = $date;
            $bulletin->is_completed = true;
            $bulletin->save();
        }
    }

    public static function exit_check_completed($exit_id, $date)
    {
        $bulletin = ExitClearanceBulletin::where('exit_id', $exit_id)->where('is_completed', false)->get();
        if (count($bulletin) === 0) {
            $exit_clearance = ExitClearance::find($exit_id);
            $exit_clearance->is_checked_completed = true;
            $exit_clearance->save();
        }
    }
}
