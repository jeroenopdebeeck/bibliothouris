<?php

/**
 * @file
 * Default theme implementation to present all user profile data.
 *
 * This template is used when viewing a registered member's profile page,
 * e.g., example.com/user/123. 123 being the users ID.
 *
 * Use render($user_profile) to print all profile items, or print a subset
 * such as render($user_profile['user_picture']). Always call
 * render($user_profile) at the end in order to print all remaining items. If
 * the item is a category, it will contain all its profile items. By default,
 * $user_profile['summary'] is provided, which contains data on the user's
 * history. Other data can be included by modules. $user_profile['user_picture']
 * is available for showing the account picture.
 *
 * Available variables:
 *   - $user_profile: An array of profile items. Use render() to print them.
 *   - Field variables: for each field instance attached to the user a
 *     corresponding variable is defined; e.g., $account->field_example has a
 *     variable $field_example defined. When needing to access a field's raw
 *     values, developers/themers are strongly encouraged to use these
 *     variables. Otherwise they will have to explicitly specify the desired
 *     field language, e.g. $account->field_example['en'], thus overriding any
 *     language negotiation rule that was previously applied.
 *
 * @see user-profile-category.tpl.php
 *   Where the html is handled for the group.
 * @see user-profile-item.tpl.php
 *   Where the html is handled for each item in the group.
 * @see template_preprocess_user_profile()
 *
 * @ingroup themeable
 */

?>

<div class="profile"<?php print $attributes; ?>>


</div>

<div id="user-profile">
    <h1>
        <?php print $user_profile['field_first_name_user'][0]['#markup'] .', '.
            $user_profile['field_last_name_user'][0]['#markup'] . ' [' . calculate_user_age($user_profile) . ']'; ?>
    </h1>

    <div id = "user-info-block1">
        <?php print $user_profile['summary']['member_for']['#title'] . ':'?> <br>
        <?php print $user_profile['summary']['member_for']['#markup'] ?>
    </div>

    <div id = "user-info-block2">

        <?php
        $postalcode = $user_profile['field_postal_code']['0']['#markup'];
        $postalcode = preg_replace('/\s+/','',$postalcode);
        ?>

        <?php print $user_profile['field_street']['0']['#markup'];?>  <?php print $user_profile['field_number']['0']['#markup']?>  <br>
        <?php print $postalcode . ' ' . $user_profile['field_city']['0']['#markup']  ?>
    </div>

    <div id = "user-info-block3">
        <?php
        $date = $user_profile['field_date_of_birth']['#items'][0]['value'];
        $date = new DateTime($date);

        ?>
        <?php print($date->format('d/m/Y'));?> <br>
        <?php print 'T: ' . $user_profile['field_phone_number']['0']['#markup']  ?> <br>
        <?php print 'M: ' . $user_profile['field_email']['0']['#markup']  ?>
    </div>





    <?php if (isset($user_profile['user_picture']['#markup'])): ?>
        <div id="user-picture">
            <?php print $user_profile['user_picture']['#markup']; ?>
        </div>
    <?php endif; ?>
</div>









<?php

/*
 * Functie om leeftijd te berekenen
 */

function calculate_user_age($user_profile) {

    $date = $user_profile['field_date_of_birth']['#items'][0]['value'];
    $date = new DateTime($date);
    $now = new DateTime();
    $interval = $now->diff($date);

    return $interval->y;
}
