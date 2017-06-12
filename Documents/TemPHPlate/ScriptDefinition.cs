using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace TemPHPlate
{
    public abstract class ScriptDefinition : Object, IPrintable
    {
        public abstract string Print();

        public static ScriptFile FromFile()
        {
            throw new System.NotImplementedException();
        }

        public static InlineScript FromCode()
        {
            throw new System.NotImplementedException();
        }
    }
}