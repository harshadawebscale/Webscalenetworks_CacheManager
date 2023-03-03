<?php
declare(strict_types = 1);

namespace Webscale\CacheManager\Setup\Patch\Data;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class ChangeConfigPath implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var AdapterInterface
     */
    private $connection;

    /**
     * @param ModuleDataSetupInterface $setup
     */
    public function __construct(ModuleDataSetupInterface $setup)
    {
        $this->moduleDataSetup = $setup;
        $this->connection = $setup->getConnection();
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        $this->renameConfigPath();
        $this->removeModuleSetup();
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * Rename config path
     *
     * @return void
     */
    private function renameConfigPath(): void
    {
        $configTable = $this->moduleDataSetup->getTable('core_config_data');

        $this->connection->update(
            $configTable,
            ['path' => 'cachemanager/config/token'],
            ['path = ?' => 'cachemanager/Setup/token']
        );

        $this->connection->getConnection()->update(
            $configTable,
            ['path' => 'cachemanager/config/query'],
            ['path = ?' => 'cachemanager/Setup/query']
        );

        $this->connection->getConnection()->update(
            $configTable,
            ['path' => 'cachemanager/config/app_name'],
            ['path = ?' => 'cachemanager/Setup/app_name']
        );
    }

    /**
     * Remove deprecated module_setup
     *
     * @return void
     */
    private function removeModuleSetup(): void
    {
        $setupModuleTable = $this->connection->getTableName('setup_module');
        $this->connection->delete($setupModuleTable, ['module = ?' => 'Webscale_CacheManager']);
    }
}
