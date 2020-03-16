<?php

namespace EasyCorp\Bundle\EasyAdminBundle\Field\Configurator;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldConfiguratorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;

final class PercentConfigurator implements FieldConfiguratorInterface
{
    public function supports(FieldInterface $field, EntityDto $entityDto): bool
    {
        return $field instanceof PercentField;
    }

    public function configure(FieldInterface $field, EntityDto $entityDto, string $action): void
    {
        if (null === $field->getValue()) {
            return;
        }

        $scale = $field->getCustomOption(PercentField::OPTION_NUM_DECIMALS);
        $symbol = $field->getCustomOption(PercentField::OPTION_SYMBOL);
        $isStoredAsFractional = $field->getCustomOption(PercentField::OPTION_STORED_AS_FRACTIONAL);
        $value = $field->getValue();

        $field->setFormattedValue(sprintf('%s%s', $isStoredAsFractional ? 100 * $value : $value, $symbol));

        $field->setFormTypeOptionIfNotSet('scale', $scale);
        $field->setFormTypeOptionIfNotSet('symbol', $symbol);
        $field->setFormTypeOptionIfNotSet('type', $isStoredAsFractional ? 'fractional' : 'integer');
    }
}
