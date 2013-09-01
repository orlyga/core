<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
   <url>
      <loc><?php echo Router::url('/',true); ?> </loc>
      <lastmod><?php echo trim($this->Time->toAtom(time())); ?></lastmod>
      <changefreq>monthly</changefreq>
      <priority>1</priority>
   </url>
   <?php $i=0; foreach ($sitemapData as $node):
     $model=(isset($node['Album'])) ? 'Album' :'Photo';
 	 $model=(isset($node['Node'])) ? 'Node' : $model;
        if (isset($node['Node']) && ($node['Node']['type'] == "page" | $node['Node']['type'] == 'node' | $node['Node']['type'] == 'blog' | $node['Node']['type'] == 'wods')||($model <>'Node')): 
   ?>
    <url>
        <loc> <?php echo Router::url('/',true).ltrim($node[$model]['path'],'/'); ?> </loc>
        <lastmod> <?php echo trim($this->Time->toAtom(strtotime($node[$model]['updated']))); ?> </lastmod>
        <priority> <?php if(isset($node[$model]['Seo']['priority']) && !empty($node[$model]['Seo']['priority'])) echo $node[$model]['Seo']['priority']; else echo $defaults['priority']['value']; ?></priority>
        <changefreq> <?php if(isset($node[$model]['Seo']['changefreq']) && !empty($node[$model]['Seo']['changefreq'])) echo $node[$model]['Seo']['changefreq']; else echo $defaults['changefreq']['value']; ?> </changefreq>
    </url>
    <?php endif; endforeach; ?>
</urlset> 
