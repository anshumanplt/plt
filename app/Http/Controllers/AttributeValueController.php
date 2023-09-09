<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the attribute values.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributeValues = AttributeValue::with('attribute')->get();
        return view('attribute_values.index', compact('attributeValues'));
    }

    /**
     * Show the form for creating a new attribute value.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attributes = Attribute::all();
        return view('attribute_values.create', compact('attributes'));
    }

    /**
     * Store a newly created attribute value in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required',
            'value' => 'required',
        ]);

        AttributeValue::create($request->all());

        return redirect()->route('attribute_values.index')
            ->with('success', 'Attribute value created successfully.');
    }

    /**
     * Display the specified attribute value.
     *
     * @param  \App\Models\AttributeValue  $attributeValue
     * @return \Illuminate\Http\Response
     */
    public function show(AttributeValue $attributeValue)
    {
        return view('attribute_values.show', compact('attributeValue'));
    }

    /**
     * Show the form for editing the specified attribute value.
     *
     * @param  \App\Models\AttributeValue  $attributeValue
     * @return \Illuminate\Http\Response
     */
    public function edit(AttributeValue $attributeValue)
    {
        $attributes = Attribute::all();
        return view('attribute_values.edit', compact('attributeValue', 'attributes'));
    }

    /**
     * Update the specified attribute value in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AttributeValue  $attributeValue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AttributeValue $attributeValue)
    {
        $request->validate([
            'attribute_id' => 'required',
            'value' => 'required',
        ]);

        $attributeValue->update($request->all());

        return redirect()->route('attribute_values.index')
            ->with('success', 'Attribute value updated successfully.');
    }

    /**
     * Remove the specified attribute value from storage.
     *
     * @param  \App\Models\AttributeValue  $attributeValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttributeValue $attributeValue)
    {
        $attributeValue->delete();

        return redirect()->route('attribute_values.index')
            ->with('success', 'Attribute value deleted successfully.');
    }
}
