<?php

declare(strict_types=1);

namespace Src\Document\Application;

use Src\Document\Domain\Contracts\DocumentRepository;

final class UpdateDocumentUseCase
{

    public function __construct(private DocumentRepository $DocumentRepository)
    {
    }

    private function dataToValueObjects( array $values ): array
    {
        $updateParams = array();

        $reflexionClass = new \ReflectionClass('Src\Document\Domain\DocumentEntity');
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

        $this->DocumentRepository->update($key, $dataToUpdate);

    }
}
