<?php

namespace Magenest\BackgroundColor\Block\Adminhtml\Form\Field\Group;

use Magenest\BackgroundColor\Block\Adminhtml\Blocks\Edit\Tab\ColorPickerRenderer;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\BlockInterface;

class ColorPicker extends AbstractFieldArray
{
    /**
     * @var ColorPickerRenderer
     */
    protected $colorPickerRenderer;

    /**
     * Prepare to renderer
     *
     * @return void
     * @throws LocalizedException
     */
    protected function _prepareToRender()
    {
        $this->addColumn('color_text', [
            'label' => __('Color Name')
        ]);

        $this->addColumn('color_input', [
            'label' => __('Color Code'),
            'renderer' => $this->getColorRenderer()
        ]);

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * Get color renderer
     *
     * @return ColorPickerRenderer|(ColorPickerRenderer&BlockInterface)|BlockInterface
     * @throws LocalizedException
     */
    private function getColorRenderer()
    {
        if (!$this->colorPickerRenderer) {
            $this->colorPickerRenderer = $this->getLayout()->createBlock(
                ColorPickerRenderer::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->colorPickerRenderer;
    }
}
