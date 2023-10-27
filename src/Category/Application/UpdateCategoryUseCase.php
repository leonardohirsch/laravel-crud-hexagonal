<?php

declare(strict_types=1);

namespace Src\Category\Application;

use Src\Category\Domain\Contracts\CategoryRepository;

final class UpdateCategoryUseCase
{

    public function __construct(private CategoryRepository $CategoryRepository)
    {
    }

    private function dataToValueObjects( array $values ): array
    {
        $updateParams = array();

        $reflexionClass = new \ReflectionClass('Src\Category\Domain\CategoryEntity');
        $constructor_params = $reflexionClass->getConstructor()->getParameters();

        foreach ($constructor_params as $param) {

            if (array_key_exists($param->name, $values) ){

                if ( $param->getType() instanceof \ReflectionNamedType &&!$param->getType()->isBuiltin() ){

                    $ValueObjectName = $param->getType()->getName();

                    $newValueInstance = new $ValueObjectName($values[$param->name]);

                    $updateParams[$param->name] = $newValueInstance->value();

                }

            }

        }

        return $updateParams;
    }

    public function execute(int|string $key, array $data): void
    {

        $dataToUpdate = $this->dataToValueObjects($data);

        $this->CategoryRepository->update($key, $dataToUpdate);

    }
}
