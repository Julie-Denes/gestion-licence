#[ORM\Column(length: 180, unique: true)]
private ?string $email = null;

public function getUserIdentifier(): string
{
    return $this->email;
}
