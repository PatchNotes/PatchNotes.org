<?php
namespace Models\Interfaces;


interface Participant {

    public function getNameAttribute();

    public function getSlugAttribute();

    public function getHrefAttribute();

}