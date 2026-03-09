<?php

include "archers_export.php";

echo count($archers_export) . " characters\n";

$output_path = "_archers/";
$output_ext = '.md';

foreach($archers_export as $character) {

    $fp = fopen($output_path . $character->nid . $output_ext, "w");

    fwrite($fp, "---\n");
    fwrite($fp, "nid: " . $character->nid . "\n");
    fwrite($fp, "title: " . $character->title . "\n");
    fwrite($fp, "created: " . $character->created . "\n");
    fwrite($fp, "changed: " . $character->changed . "\n");
    fwrite($fp, "revision_timestamp: " . $character->revision_timestamp . "\n");

    if(!empty($character->field_forenames['und'])) {
        fwrite($fp, "forenames: " . $character->field_forenames['und'][0]['safe_value'] . "\n");
    }
    if(!empty($character->field_family_name['und'])) {
        fwrite($fp, "family_name: " . $character->field_family_name['und'][0]['safe_value'] . "\n");
    }
    if(!empty($character->field_maiden_name['und'])) {
        fwrite($fp, "maiden_name: " . $character->field_maiden_name['und'][0]['safe_value'] . "\n");
    }
    if(!empty($character->field_gender['und'])) {
        fwrite($fp, "gender: " . ($character->field_gender['und'][0]['tid'] == '8' ? 'male' : 'female') . "\n");       #  '8' Male, '9' Female,
    }

    if(!empty($character->field_spouse['und'])) {
        $spouses = $character->field_spouse['und'];
        fwrite($fp, "spouse: \n");
        foreach($spouses as $spouse) {
            fwrite($fp, "    - " . $spouse['target_id'] . "\n");
        }
    }

    if(!empty($character->field_non_marital_rel['und'])) {
        $partners = $character->field_non_marital_rel['und'];
        fwrite($fp, "partner: \n");
        foreach($partners as $partner) {
            fwrite($fp, "    - " . $partner['target_id'] . "\n");
        }
    }
    if(!empty($character->field_father['und'])) {
        fwrite($fp, "father: " . $character->field_father['und'][0]['target_id'] . "\n");
    }
    if(!empty($character->field_mother['und'])) {
        fwrite($fp, "mother: " . $character->field_mother['und'][0]['target_id'] . "\n");
    }

    if(!empty($character->field_children['und'])) {
        $children = $character->field_children['und'];
        fwrite($fp, "children: \n");
        foreach($children as $child) {
            fwrite($fp, "    - " . $child['target_id'] . "\n");
        }
    }

    if(!empty($character->field_actor['und'])) {
        $actors = $character->field_actor['und'];
        fwrite($fp, "actor: \n");
        foreach($actors as $actor) {
            fwrite($fp, "    - " . $actor['safe_value'] . "\n");
        }
    }

    # Partial date can be YYYY, YYYY-MM or YYYY-MM-DD
    if(!empty($character->field_date_of_birth['und'])) {
        $dob = $character->field_date_of_birth['und'][0]['from'];
        fwrite($fp, 'date_of_birth: "' . $dob['year']);
        if(!empty($dob['month'])) {
             fwrite($fp, '-' . str_pad($dob['month'], 2, '0', STR_PAD_LEFT));
        }
        if(!empty($dob['day'])) {
            fwrite($fp, '-' . str_pad($dob['day'], 2, '0', STR_PAD_LEFT));
        }
        fwrite($fp, '"' . "\n");        
    }

    # Partial date can be YYYY, YYYY-MM or YYYY-MM-DD
    if(!empty($character->field_date_of_death['und'])) {
        $dod = $character->field_date_of_death['und'][0]['from'];
        fwrite($fp, 'date_of_death: "' . $dod['year']);
        if(!empty($dod['month'])) {
             fwrite($fp, '-' . str_pad($dod['month'], 2, '0', STR_PAD_LEFT));
        }
        if(!empty($dod['day'])) {
            fwrite($fp, '-' . str_pad($dod['day'], 2, '0', STR_PAD_LEFT));
        }
        fwrite($fp, '"' . "\n");
    }

    if(!empty($character->field_bbc_webpage['und'])) {
        fwrite($fp, "bbc_url: " . $character->field_bbc_webpage['und'][0]['url'] . "\n");
    }

    fwrite($fp, "---\n");

    if(!empty($character->field_notes['und'])) {
        fwrite($fp, $character->field_notes['und'][0]['safe_value'] . "\n");
        fwrite($fp, "---\n");
    }

    fclose($fp);

}



