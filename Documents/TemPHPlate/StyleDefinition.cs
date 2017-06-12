using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace TemPHPlate
{
    public abstract class StyleDefinition : Object, IPrintable
    {
        public abstract string Print();

        public static StyleSheet FromFile()
        {
            throw new System.NotImplementedException();
        }

        public static InlineStyle FromCode()
        {
            throw new System.NotImplementedException();
        }
    }
}