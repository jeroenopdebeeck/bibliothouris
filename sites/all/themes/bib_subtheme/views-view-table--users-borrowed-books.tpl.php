<?php

/**
 * @file
 * Template to display a view as a table.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $caption: The caption for this table. May be empty.
 * - $header_classes: An array of header classes keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $classes: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: An array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 * - $field_classes: An array of classes to apply to each field, indexed by
 *   field id, then row number. This matches the index in $rows.
 * @ingroup views_templates
 */

include_once("workingDays.php");
?>
<table <?php if ($classes) { print 'class="'. $classes . '" '; } ?><?php print $attributes; ?>>
    <?php if (!empty($title) || !empty($caption)) : ?>
        <caption><?php print $caption . $title; ?></caption>
    <?php endif; ?>
    <?php if (!empty($header)) : ?>
        <thead>
        <tr>
            <?php foreach ($header as $field => $label): ?>
                <th <?php if ($header_classes[$field]) { print 'class="'. $header_classes[$field] . '" '; } ?>>
                    <?php print $label; ?>
                </th>
            <?php endforeach; ?>
        </tr>
        </thead>
    <?php endif; ?>
    <tbody>

    <?php foreach ($rows as $row_count => $row): ?>

        <tr <?php if ($row_classes[$row_count]) { print 'class="' . implode(' ', $row_classes[$row_count]) .'"';  } ?>>
            <?php foreach ($row as $field => $content): ?>


                <?php if($field == 'field_lend_date_1'){

                    $date = strip_tags($content);
                    $duedate = new DateTime($date);
                    $today = new DateTime('2015-05-2');
                    $nrdays = getWorkingDays($duedate,$today) - 1;
                    $overdue = "0 days";
                    $fine = 0;
                    if($duedate < $today){
                        $overdue = $nrdays;
                        $fine = $nrdays * 0.30;
                    }



                } ?>
                <?php if ( $field != 'nid' && $field !='nothing' && $field != 'nothing_1'): ?>
                <td <?php if ($field_classes[$field][$row_count]) { print 'class="'. $field_classes[$field][$row_count] . '" '; } ?><?php print drupal_attributes($field_attributes[$field][$row_count]); ?>>
                    <?php print $content; ?>
                </td>
                <?php endif; ?>

                <?php if ($field == 'nothing'): ?>

                         <td> <?php print $overdue; ?></td>

                <?php endif; ?>

                <?php if ($field == 'nothing_1'): ?>

                       <td> <?php print "€ " . $fine; ?> </td>

                <?php endif; ?>

                <?php if ($field == 'nid'): ?>

                    <?php $uid = arg(1); ?>
                    <?php echo '<td><a class="btn" href="#" onclick="myModule_return_book( \'' . $content  .'\',\'' . $uid . '\')">Return book</a></td>'; ?>
                <?php endif; ?>







            <?php endforeach; ?>

        </tr>
    <?php endforeach; ?>
    </tbody>
</table>



<script>
    function myModule_return_book(id,uid) {
        jQuery.get("http://localhost/bibliotheek/node/return/book/".concat(id).concat("/").concat(uid));
        location.reload();
    }
</script>





