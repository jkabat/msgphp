<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\Doctrine;

use MsgPhp\Domain\Infra\Doctrine\MappingConfig;
use MsgPhp\Domain\Infra\Doctrine\ObjectMappingProviderInterface;
use MsgPhp\User\Entity\Credential;
use MsgPhp\User\Entity\Features;
use MsgPhp\User\Entity\Fields;
use MsgPhp\User\Entity\Role;
use MsgPhp\User\Entity\User;
use MsgPhp\User\Entity\UserEmail;
use MsgPhp\User\Entity\UserRole;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @internal
 */
final class ObjectMappings implements ObjectMappingProviderInterface
{
    private const CREDENTIALS = [
        Features\EmailCredential::class => Credential\Email::class,
        Features\EmailPasswordCredential::class => Credential\EmailPassword::class,
        Features\NicknameCredential::class => Credential\Nickname::class,
        Features\NicknamePasswordCredential::class => Credential\NicknamePassword::class,
        Features\TokenCredential::class => Credential\Token::class,
    ];

    public static function provideObjectMappings(MappingConfig $config): iterable
    {
        foreach (self::CREDENTIALS as $object => $credential) {
            yield $object => [
                'credential' => [
                    'type' => self::TYPE_EMBEDDED,
                    'class' => $credential,
                    'columnPrefix' => null,
                ],
            ];
        }

        yield Features\ResettablePassword::class => [
            'passwordResetToken' => [
                'type' => 'string',
                'unique' => true,
                'nullable' => true,
                'length' => $config->keyMaxLength,
            ],
            'passwordRequestedAt' => [
                'type' => 'datetime',
                'nullable' => true,
            ],
        ];
        yield Fields\EmailsField::class => [
            'emails' => [
                'type' => self::TYPE_ONE_TO_MANY,
                'targetEntity' => UserEmail::class,
                'mappedBy' => 'user',
                'indexBy' => 'email',
            ],
        ];
        yield Fields\RoleField::class => [
            'role' => [
                'type' => self::TYPE_MANY_TO_ONE,
                'targetEntity' => Role::class,
                'joinColumns' => [
                    ['referencedColumnName' => 'name', 'nullable' => false],
                ],
            ],
        ];
        yield Fields\RolesField::class => [
            'roles' => [
                'type' => self::TYPE_ONE_TO_MANY,
                'targetEntity' => UserRole::class,
                'mappedBy' => 'user',
            ],
        ];
        yield Fields\UserField::class => [
            'user' => [
                'type' => self::TYPE_MANY_TO_ONE,
                'targetEntity' => User::class,
                'joinColumns' => [
                    ['nullable' => false],
                ],
            ],
        ];
    }
}
