<div id="app_gallery" class="app-gallery">
    <div id="app_gallery_image_container" class="app-gallery-image-container">
        @foreach($gallery as $image)
            <div class="hidden-xs-up app-gallery-image-item" style="background-image: url('{{ $image }}')"></div>
        @endforeach
    </div>
    <a href="#" id="app_gallery_prev_button" class="app-gallery-prev">
        <img src="/img/gallery/prev.png"/>
    </a>
    <a href="#" id="app_gallery_next_button" class="app-gallery-next">
        <img src="/img/gallery/next.png"/>
    </a>
</div>
<div class="app-gallery-data  app-card-b-divider">
    <span id="app_gallery_image_current"></span>&nbsp; from &nbsp;<span id="app_gallery_image_count"></span>
</div>