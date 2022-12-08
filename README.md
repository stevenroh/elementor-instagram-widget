# elementor-instagram-widget

![Release (latest)](https://img.shields.io/github/v/release/stevenroh/elementor-instagram-widget?display_name=tag)

## How it works

A custom python script download dumps all the content from the specified Instagram account. (available soon)

A JSON file containing all the post captions and image urls is build. All these files are stored on a web server and made available to this Elementor Widget plugin.

## Usage

### Maintain 1:1 aspect ratio

```
.swiper-slide-image {
  object-fit: cover;
  height: 100% !important;
}

.swiper-container .swiper-slide figure {
  aspect-ratio: 1/1;
}
```
