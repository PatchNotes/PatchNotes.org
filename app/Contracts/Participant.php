<?php
namespace PatchNotes\Contracts;


interface Participant {

    public function getNameAttribute();

    public function getSlugAttribute();

    public function getHrefAttribute();

}