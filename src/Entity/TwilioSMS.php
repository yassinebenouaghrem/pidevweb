<?php

namespace App\Entity;

use App\Repository\TwilioSMSRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TwilioSMSRepository::class)
 */
class TwilioSMS
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $account_sid = 'AC43d34188da6404900ee0da1aadf78d54';

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $auth_token = '7fce20e66d627810f030efe192ef0e7b';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccountSid(): ?string
    {
        return $this->account_sid;
    }

    public function setAccountSid(string $account_sid): self
    {
        $this->account_sid = $account_sid;

        return $this;
    }

    public function getAuthToken(): ?string
    {
        return $this->auth_token;
    }

    public function setAuthToken(string $auth_token): self
    {
        $this->auth_token = $auth_token;

        return $this;
    }
}
