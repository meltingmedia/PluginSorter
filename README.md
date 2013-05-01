# Plugin Sorter

Plugin Sorter is a Custom Manager Page allowing you to define the execution order of your plugins, per event.

## Requirements

* PHP >= 5.3
* MODX Revolution 2.2+

## Installation

Download & install from the Package Manager.

During setup, you will be offered to :

### Automatically sort existing events

This is a required action to make Plugin Sorter work.You can skip it during the setup and perform this action from the CMP later on.
What it does is assign & increments a `priority` value to each `modPluginEvent` object.

In the CMP, you will find a button which allows you to perform this action at will.
If you click the button when "All events" if set in the near combo box, the sorting will be done for all system events. If you filter to a particular system event, the sorting will only be done for that event.

### Automatically refresh cache

When manipulating the modPlugin objects (and related), MODX needs to refresh its cache to "activate" the changes.
Activate this option to do it automatically after each action that requires it.

If you know what you are doing, you can safely skip it, and manully clear the cache when you are satisfied with your configuration.

## Notes

Users must have the `save_plugin` right/flag to see the CMP menu.

## License

Plugin Sorter is licensed under the MIT license.
Copyright 2013 Melting Media <https://github.com/meltingmedia/PluginSorter>
