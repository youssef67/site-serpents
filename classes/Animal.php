<?php

namespace classes;

class Animal
{
    private String $nom;
    private Race $race;
    private bool $genre;
    private int $dureeDeVie;
    private \DateTime $dateNaissance;

    /**
     * @param String $nom
     * @param Race $race
     * @param bool $genre
     * @param int $dureeDeVie
     * @param \DateTime $dateNaissance
     */
    public function __construct(string $nom, Race $race, bool $genre, int $dureeDeVie, \DateTime $dateNaissance)
    {
        $this->nom = $nom;
        $this->race = $race;
        $this->genre = $genre;
        $this->dureeDeVie = $dureeDeVie;
        $this->dateNaissance = $dateNaissance;
    }

    public function getNom(): string { return $this->nom; }
    public function getRace(): Race { return $this->race; }
    public function getDureeDeVie(): int { return $this->dureeDeVie; }
    public function getDateNaissance(): \DateTime { return $this->dateNaissance; }

    public function isMale(): bool { return $this->genre; }
    public function setNom(string $nom): void { $this->nom = $nom; }
    public function setRace(Race $race): void { $this->race = $race; }
    public function setGenre(bool $genre): void { $this->genre = $genre; }
    public function setDureeDeVie(int $dureeDeVie): void { $this->dureeDeVie = $dureeDeVie; }
    public function setDateNaissance(\DateTime $dateNaissance): void { $this->dateNaissance = $dateNaissance; }




}