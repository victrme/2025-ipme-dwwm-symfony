<?php

namespace App\Slugger;

interface SlugInterface
{
    public function setSlug(string $slug): self;

    public function getFields(): ?string;
}
