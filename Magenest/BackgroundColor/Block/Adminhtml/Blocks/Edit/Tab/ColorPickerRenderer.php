<?php

namespace Magenest\BackgroundColor\Block\Adminhtml\Blocks\Edit\Tab;

use Magento\Framework\View\Element\AbstractBlock;

class ColorPickerRenderer extends AbstractBlock
{
    /**
     * @inheritDoc
     */
    protected function _toHtml()
    {
        $html = '<input type="text" name="' . $this->getInputName() . '" id="' . $this->getInputId() . '" ';
        $html .= ' <script type="text/javascript">
                require(["jquery","jquery/colorpicker/js/colorpicker"], function ($) {
                    $(document).ready(function () {
                        var $el = $("#' . $this->getInputId() . '");
                        // Attach the color picker
                        $el.ColorPicker({
                            onChange: function (hsb, hex, rgb) {
                                $el.css("backgroundColor", "#" + hex).val("#" + hex);
                            }
                        });
                    });
                });
                </script> ';

        return $html;
    }
}
