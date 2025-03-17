@props(['items' => []])

<div id="tree-view" class="bg-white rounded-sm p-4 dark:bg-neutral-900" role="tree" aria-orientation="vertical" data-hs-tree-view="">
    @foreach ($items as $item)
        <x-lara-ui::tree.item :item="$item" />
    @endforeach
</div>
