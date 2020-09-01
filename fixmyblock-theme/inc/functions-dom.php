<?php

// Lots of very generic function names here, so we're
// organising them into a namespace as a precaution.
namespace FMB\DOM;


// Convert a given HTML structure into a nested array of tag details.
// $html should be a single HTML tag. It can contain children.
// If you provide more than one HTML tag, only the first will be returned.
function html_element_as_array( $html ) {
    $dom = new \DOMDocument( '1.0', 'UTF-8' );
    $dom->loadHTML( '<?xml encoding="utf-8" ?>' . $html );
    return dom_node_to_array( $dom->getElementsByTagName('body')->item(0)->childNodes->item(0) );
}


// A fairly simplistic HTML DOM scraper, extracting tagNames, textContents,
// attributes, and children from HTML elements, and returning them as a
// nested array.
// $el should be a DOMDocument XML_HTML_DOCUMENT_NODE or XML_ELEMENT_NODE.
function dom_node_to_array( $el ) {
    $arr = array(
        'nodeType' => null,
        'tagName' => null,
        'textContent' => null,
        'attributes' => array(),
        'children' => array(),
    );

    if ( $el->nodeType == XML_ELEMENT_NODE ) {
        $arr['nodeType'] = 'XML_ELEMENT_NODE';
    } else if ( $el->nodeType == XML_TEXT_NODE ) {
        $arr['nodeType'] = 'XML_TEXT_NODE';
    } else if ( $el->nodeType == XML_HTML_DOCUMENT_NODE ) {
        $arr['nodeType'] = 'XML_HTML_DOCUMENT_NODE';
    } else {
        return array();
    }

    if ( $el->nodeType == XML_ELEMENT_NODE ) {
        $arr['tagName'] = $el->tagName;
    }

    if ( $el->textContent ) {
        $arr['textContent'] = $el->textContent;
    }

    $attributeNodes = $el->attributes;

    if ( $attributeNodes ) {
        for ( $i = 0; $i < $attributeNodes->length; $i++ ) {
            $arr['attributes'][] = array(
                'name' => $attributeNodes->item($i)->nodeName,
                'value' => $attributeNodes->item($i)->nodeValue,
            );
        }
    }

    $childNodes = $el->childNodes;

    if ( $childNodes ) {
        for ( $i = 0; $i < $childNodes->length; $i++ ) {
            $child_arr = dom_node_to_array( $childNodes->item($i) );
            if ( $child_arr ) {
                $arr['children'][] = $child_arr;
            }
        }
    }

    return $arr;
}


function get_element_attribute( $el, $attr ) {
    foreach ( $el['attributes'] as $i => $attribute ) {
        if ( $attribute['name'] == $attr ) {
            return $attribute['value'];
        }
    }
    return null;
}


function get_inner_html( $el ) {
    $html = '';

    foreach( $el['children'] as $child ) {
        $html .= get_outer_html( $child );
    }

    return $html;
}


function get_outer_html( $el ) {
    $html = '';

    if ( $el['tagName'] ) {
        $html .= get_opening_tag_html( $el );
        foreach ( $el['children'] as $child ) {
            $html .= get_outer_html( $child );
        }
        $html .= get_closing_tag_html( $el );
    } else if ( $el['textContent'] ) {
        $html .= $el['textContent'];
    }

    return $html;
}


function get_opening_tag_html( $el ) {
    $attributes = '';
    foreach ( $el['attributes'] as $attribute ) {
        $attributes .= sprintf(
            '%s="%s"',
            $attribute['name'],
            esc_attr( $attribute['value'] )
        );
    }

    return sprintf(
        '<%s %s>',
        $el['tagName'],
        $attributes
    );
}


function get_closing_tag_html( $el ) {
    return sprintf(
        '</%s>',
        $el['tagName']
    );
}


function remove_attribute( $attr, $html ) {
    return preg_replace(
        '%' . $attr . '="[^"]+"%',
        '',
        $html
    );
}
