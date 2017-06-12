﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace TemPHPlate
{
    public abstract class Printable : Object, IPrintable
    {
        public virtual string Print()
        {
            return PrintInternal();
        }

        protected abstract string PrintInternal();
    }
}