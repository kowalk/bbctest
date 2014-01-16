<?php if( !empty($tplVars['sResults']) ): ?>

    <h2 class="serach-title">Search results</h2>
    <div class="results-count"><?=$tplVars['sResults']['count'];?> Programmes found</div>
    <div class="search-results">
        <?php foreach($tplVars['sResults']['blocklist'] as $row): ?>
            <div class="result-row">
                <div class="r-image"><img src="<?=  str_replace('$recipe', '192x108', $row['image_template_url'])?>" alt="" /></div>
                <div class="r-title"><?=$row['passionsite_title']?></div>
                <div class="r-desc"><?=$row['synopsis']?></div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif;?>