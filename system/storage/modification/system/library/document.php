<?php
class Document {
	private $title;

	// SEO CMS vars
	private $sc_og_image;
	private $sc_og_description;
	private $sc_og_title;
	private $sc_og_type;
	private $sc_og_url;
	private $sc_robots;
	private $sc_hreflang = array();
	private $sc_removelinks = array();
	//End of SEO CMS vars

	private $description;
	private $keywords;
    // OCFilter start
    private $noindex = false;
    // OCFilter end
	private $links = array();
	private $styles = array();
	private $scripts = array();
	private $og_image;
	private $name;

  // OCFilter start
  public function setNoindex($state = false) {
      $this->noindex = $state;
  }

  public function isNoindex() {
      return $this->noindex;
  }
  // OCFilter end

	public function setTitle($title) {
		$this->title = $title;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setKeywords($keywords) {
		$this->keywords = $keywords;
	}

	public function getKeywords() {
		return $this->keywords;
	}

	public function addLink($href, $rel) {
		$this->links[$href] = array(
			'href' => $href,
			'rel'  => $rel
		);
	}

    // OCFilter canonical fix start
    public function deleteLink($rel) {
        foreach ($this->links as $href => $link) {
            if ($link['rel'] == $rel) {
                unset($this->links[$href]);
            }
        }
    }
    // OCFilter canonical fix end


    // SEO CMS functions
	public function setSCRobots($str) {
		$this->sc_robots = $str;
	}
	public function getSCRobots() {
		return $this->sc_robots;
	}
	public function setSCHreflang($hreflang = array()) {
		$this->sc_hreflang = $hreflang;
	}
	public function getSCHreflang() {
		return $this->sc_hreflang;
	}
	public function setSCOgImage($image) {
		$this->sc_og_image = $image;
	}
	public function getSCOgImage() {
		return $this->sc_og_image;
	}
	public function setSCOgType($og_type) {
		$this->sc_og_type = $og_type;
	}
	public function getSCOgType() {
		return $this->sc_og_type;
	}
	public function setSCOgTitle($title) {
		$this->sc_og_title = $title;
	}
	public function getSCOgTitle() {
		return $this->sc_og_title;
	}
	public function setSCOgDescription($description) {
		$this->sc_og_description = $description;
	}
	public function getSCOgDescription() {
		return $this->sc_og_description;
	}
	public function setSCOgUrl($url) {
		$this->sc_og_url = $url;
	}
	public function getSCOgUrl() {
		return $this->sc_og_url;
	}
	public function removeSCLink($href) {
		$this->sc_removelinks[$href] = $href;
	}
	//End of SEO CMS functions

	public function getLinks() {
		
		// SEO CMS code
		if (is_array($this->links) && !empty($this->links)) {
			foreach ($this->links as $links => $linksarray) {
				if (isset($this->sc_removelinks) && !empty($this->sc_removelinks) && isset($this->sc_removelinks[$links])) {
					unset($this->links[$links]);
				}
			}
		}
		//End of SEO CMS code
		return $this->links;

	}

	public function addStyle($href, $rel = 'stylesheet', $media = 'screen') {
		$this->styles[$href] = array(
			'href'  => $href,
			'rel'   => $rel,
			'media' => $media
		);
	}

	public function getStyles() {
		return $this->styles;
	}

	public function addScript($href, $postion = 'header') {
		$this->scripts[$postion][$href] = $href;
	}

	public function getScripts($postion = 'header') {
		if (isset($this->scripts[$postion])) {
			return $this->scripts[$postion];
		} else {
			return array();
		}
	}

	public function setOgImage($image) {
		$this->og_image = $image;
	}

	public function getOgImage() {
		return $this->og_image;
	}
	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

}
