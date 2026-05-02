<?php

namespace lemage\tables\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
    /** @var \phpbb\template\template */
    protected $template;

    public function __construct(\phpbb\template\template $template)
    {
        $this->template = $template;
    }

    public static function getSubscribedEvents()
    {
        return [
            'core.text_formatter_s9e_configure_after' => 'configure_tables',
            'core.page_header'                        => 'add_assets',
        ];
    }

    /**
     * Configure s9e text formatter for tables
     */
    public function configure_tables($event)
    {
        $configurator = $event['configurator'];

        // Table tag
        if (!isset($configurator->BBCodes['table'])) {
            $configurator->BBCodes->addCustom(
                '[table]{TEXT}[/table]',
                '<div class="lemage-table-wrapper"><table class="lemage-table">{TEXT}</table></div>'
            );
        }

        // Table Row
        if (!isset($configurator->BBCodes['tr'])) {
            $configurator->BBCodes->addCustom(
                '[tr]{TEXT}[/tr]',
                '<tr>{TEXT}</tr>'
            );
        }

        // Table Header
        if (!isset($configurator->BBCodes['th'])) {
            $configurator->BBCodes->addCustom(
                '[th]{TEXT}[/th]',
                '<th>{TEXT}</th>'
            );
        }

        // Table Cell
        if (!isset($configurator->BBCodes['td'])) {
            $configurator->BBCodes->addCustom(
                '[td]{TEXT}[/td]',
                '<td>{TEXT}</td>'
            );
        }
    }

    /**
     * Add CSS and Template logic
     */
    public function add_assets($event)
    {
        // Assets are usually added via template events in phpBB 3.3+, 
        // but we can also use page_header if needed.
        // For this extension, we'll use template events for better compatibility.
    }
}
