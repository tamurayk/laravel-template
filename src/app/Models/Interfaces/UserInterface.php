<?php
declare(strict_types=1);

// FIXME: Laravel の標準的な慣習に従うように修正
namespace App\Models\Interfaces;

use App\Models\Eloquents\Task;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Interface UserInterface
 * @package App\Models\Interfaces
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Collection|Task[]|null $tasks
 */
interface UserInterface extends BaseInterface
{
    /**
     * @return HasMany<Task>
     */
    public function tasks(): HasMany;
}
