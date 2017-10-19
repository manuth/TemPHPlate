using System;
using System.Collections.Generic;
using System.Globalization;

namespace TemPHPlate
{
    public abstract class WebContent : Printable
    {
        public string Title
        {
            get => default(string);
            set
            {
            }
        }

        public CultureInfo Locale
        {
            get => default(CultureInfo);
            set
            {
            }
        }

        public List<StyleDefinition> StyleDefinitions
        {
            get => default(List<StyleDefinition>);
            set
            {
            }
        }

        public List<ScriptDefinition> ScriptDefinitions
        {
            get => default(List<ScriptDefinition>);
            set
            {
            }
        }

        public Template Template
        {
            get => default(Template);
            set
            {
            }
        }
    }
}